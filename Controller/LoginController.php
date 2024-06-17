<?php
    declare(strict_types=1);

	use model\classes\Controller;
	use model\classes\Query;
	use model\classes\Validate;

    /**
     * A class that contains the methods to login and logout. 
     */
    class LoginController extends Controller
    {               
        public function __construct(
			private object $dbcon = DB_CON,
			private string $message = "",
			private array $fields = [],
			private array $limited_access_data = [],
			private int $remaining_time = 0
		)
        {
            
        }

        /* Checking if the user is logged in. If not, it checks if the email and password are not
        empty. If they are not empty, it checks if the email exists in the database. If it does, it
        checks if the password is correct. If it is, it sets the session variables and redirects to
        the home page. If the email does not exist, it displays an error message. If the password is
        incorrect, it displays an error message. If the email and password are empty, it displays
        the login form. */
        public function index(): void
        {			
            // Define objects						
			$validate 		= new Validate;
			$query_object 	= new Query();														
			
			try {
				if(!isset($_SESSION['id_user'])) {										
					// Test for restrictions
					$this->limited_access_data = $query_object->selectOneBy("limit_access", "ip", $_SERVER['REMOTE_ADDR']);						

					// If the IP is restricted, return the remaining time
					if(count($this->limited_access_data) > 0) {						
						if($this->limited_access_data['failed_tries'] >= 3) $this->remaining_time = $this->limited_access_data['restriction_time'] - time();
					}						
					
					if($_SERVER['REQUEST_METHOD'] == 'POST') {	
						// Get values from the form
						$this->fields = [
							'email'		=>	$validate->test_input($_REQUEST['email']),
							'password'	=>	$validate->test_input($_REQUEST['password'])
						];																																																		

						// Try to login
						if ($this->remaining_time <= 0) {																							
							if($validate->validate_form($this->fields)) {											
								$query = "SELECT * FROM user INNER JOIN roles USING(id_role) WHERE email = :val";
		
								$stm = $this->dbcon->pdo->prepare($query);
								$stm->bindValue(":val", $this->fields['email']);				
								$stm->execute();					
		
								// Look for a user 
								if($stm->rowCount() == 1) {
									$result = $stm->fetch(PDO::FETCH_ASSOC);					
									
									// Testing passwords
									if(password_verify($this->fields['password'], $result['password'])) {												
										$_SESSION['id_user'] = $result['id'];						
										$_SESSION['user_name'] = $result['user_name'];
										$_SESSION['role'] = $result['role'];																				
										$stm->closeCursor();										
										
										// Delete the restriction time
										if(isset($this->limited_access_data['id'])) $query_object->deleteRegistry("limit_access", $this->limited_access_data['id']);										

										// Redirect to home
										header("Location: /");																	
									}
									else {																				
										$this->message = "<p class='text-center error'>Bad credentials</p>";																																																																																										
									}			
								}
								else {									
									$this->message = "<p class='text-center error'>Bad credentials</p>";																							
								}
								
								// Search if there is a restriction time
								if(isset($this->limited_access_data['id'])) {																																										
									// Update the restriction time										
									$this->limited_access_data['failed_tries'] += 1;
									$this->limited_access_data['restriction_time'] = time() + (5 * 60 );											
									$query_object->updateRow("limit_access", $this->limited_access_data, $this->limited_access_data['id']);
								}
								else {
									$this->limited_access_data['failed_tries'] = 1;

									// Insert into table limit_access
									$data = [
										'ip' => $_SERVER['REMOTE_ADDR'],
										'restriction_time' => time() + (5 * 60),
										'failed_tries' => $this->limited_access_data['failed_tries'],
										'created_at' => date('Y-m-d H:i:s')
									];

									if($validate->validate_form($data)) {											
										$query_object->insertInto("limit_access", $data);
									}
								}
							}
							else {								
								$this->message = $validate->get_msg();
							}
						}
						else {
							$this->limited_access_data['failed_tries'] = 0;

							// Display message with remaining time (formatted)
							$minutes = floor($this->remaining_time / 60);
							$seconds = $this->remaining_time % 60;
							
							$this->message = "<p class='alert alert-danger text-center'>Please wait for " . $minutes . " minutes and " . $seconds . " seconds before trying again.</p>";							
						}																							
					}
					
					$this->render("/view/login_view.php", [
						'message'	=>	$this->message,
						'fields'	=>	$this->fields
					]);	
				}
				else {		
					header("Location: /");
				}				
						
			} catch (\Throwable $th) {					
				$this->message = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				
				$this->render("/view/database_error.php", [
					'message'	=>	$this->message
				]);			
			}											
        }

        /* Unsetting the session variables and destroying the session. */
        public function logout(): void
        {
            unset($_SESSION['id_user']);
			unset($_SESSION['user_name']);
			unset($_SESSION['role']);
		  
			$_SESSION = array();
		  
			session_destroy();
			setcookie('PHPSESSID', "0", time() - 3600);		  			            

			header("Location: /login");	
        }
    }    
?>
