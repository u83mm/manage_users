<?php
    declare(strict_types=1);

	use model\classes\Validate;

    /**
     * A class that contains the methods to login and logout. 
     */
    class LoginController
    {               
        public function __construct(private object $dbcon = DB_CON)
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
            // define variables			
			$fields = [
				'email'		=> "",
				'password'	=> ""
			];

			$validate = new Validate;
			
			try {
				if(!isset($_SESSION['id_user'])) {	
					if($_SERVER['REQUEST_METHOD'] == 'POST') {
						// get values from the form
						$fields = [
							'email'	=>	$validate->validate_email($_REQUEST['email']) ? $validate->test_input($_REQUEST['email']) : false,
							'password'	=>	$validate->test_input($_REQUEST['password'])
						];
	
						if(!$fields['email']) $error_msg = "<p class='text-center error'>Enter a valid e-mail</p>";
						elseif (!$validate->validate_form($fields)) {
							$error_msg = $validate->get_msg();	
						}
						else {
							// hacemos la consulta a la DB				
							$query = "SELECT * FROM user INNER JOIN roles USING(id_role) WHERE email = :val";
	
							$stm = $this->dbcon->pdo->prepare($query);
							$stm->bindValue(":val", $fields['email']);				
							$stm->execute();					
	
							// si encuentra el usuario en la DB
							if($stm->rowCount() == 1) {
								$result = $stm->fetch(PDO::FETCH_ASSOC);					
								
								// comprueba que la contraseña introducida coincide con la de la DB
								if(password_verify($fields['password'], $result['password'])) {												
									$_SESSION['id_user'] = $result['id_user'];						
									$_SESSION['user_name'] = $result['user_name'];
									$_SESSION['role'] = $result['role'];												
									$stm->closeCursor();
																	
									header("Location: /");							
								}
								else {
									$error_msg = "<p class='text-center error'>Bad credentials</p>";								
								}			
							}
							else {		
								$error_msg = "<p class='text-center error'>Bad credentials</p>";																							
							}
						}											
					}									
				}
				else {		
					header("Location: /");
				}
						
			} catch (\Throwable $th) {					
				$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
					de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				include(SITE_ROOT . "/../view/database_error.php");				
			}
									
			include(SITE_ROOT . "/../view/login_view.php");			
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