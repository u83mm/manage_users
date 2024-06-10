<?php
    declare(strict_types=1);

	use model\classes\Controller;
	use model\classes\Validate;

    /**
     * A class that contains the methods to login and logout. 
     */
    class LoginController extends Controller
    {               
        public function __construct(
			private object $dbcon = DB_CON,
			private string $message = "",
			private array $fields = []
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
            // Define variables						
			$validate = new Validate;														
			
			try {
				if(!isset($_SESSION['id_user'])) {					
					$_SESSION['access_restriction_time'] = !isset($_SESSION['access_restriction_time']) ? 0 : $_SESSION['access_restriction_time'];

					if($_SERVER['REQUEST_METHOD'] == 'POST') {	
						// Get values from the form
						$this->fields = [
							'email'		=>	$validate->test_input($_REQUEST['email']),
							'password'	=>	$validate->test_input($_REQUEST['password'])
						];															
					
						// Check if a restriction time is already set
						if(isset($_SESSION['access_try']) && $_SESSION['access_try'] >= 3) {
							// Set the restriction time to 5 minutes from now
							$_SESSION['access_restriction_time'] = time() + (5 * 60); // 5 minutes in seconds
						}						

						// Calculate the remaining time
						$remainingTime = $_SESSION['access_restriction_time'] ? $_SESSION['access_restriction_time'] - time() : 0;						

						// Try to login
						if ($remainingTime <= 0) {																							
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
										$_SESSION['id_user'] = $result['id_user'];						
										$_SESSION['user_name'] = $result['user_name'];
										$_SESSION['role'] = $result['role'];																				
										$stm->closeCursor();
																		
										header("Location: /");							
									}
									else {
										$_SESSION['access_try'] = isset($_SESSION['access_try']) ? $_SESSION['access_try'] += 1 : 1;
										if($_SESSION['access_try'] >= 3) $_SESSION['access_restriction_time'] = time() + (5 * 60 );
										$this->message = "<p class='text-center error'>Bad credentials</p>";								
									}			
								}
								else {
									isset($_SESSION['access_try']) ? $_SESSION['access_try'] ++ : 0;	
									$this->message = "<p class='text-center error'>Bad credentials</p>";																							
								}								
							}
							else {
								isset($_SESSION['access_try']) ? $_SESSION['access_try'] ++ : 0;
								$this->message = $validate->get_msg();
							}
						}
						else {
							$_SESSION['access_try'] = 0;							

							// Display message with remaining time (formatted)
							$minutes = floor($remainingTime / 60);
							$seconds = $remainingTime % 60;
							
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