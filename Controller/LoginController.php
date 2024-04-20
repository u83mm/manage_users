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
					if($_SERVER['REQUEST_METHOD'] == 'POST') {
						if(isset($_SESSION['access_try']) && $_SESSION['access_try'] >= 3) throw new Exception("You have reached the maximum number of tries", 1);					
						
						// Get values from the form
						$this->fields = [
							'email'		=>	$validate->test_input($_REQUEST['email']),
							'password'	=>	$validate->test_input($_REQUEST['password'])
						];
	
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
									isset($_SESSION['access_try']) ? $_SESSION['access_try'] ++ : 0;
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
				}
				else {		
					header("Location: /");
				}
						
			} catch (\Throwable $th) {					
				$this->message = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
					de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				include(SITE_ROOT . "/../view/database_error.php");				
			}
							
			$this->render("/view/login_view.php", [
				'message'	=>	$this->message,
				'fields'	=>	$this->fields
			]);		
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