<?php
    declare(strict_types=1);

    use model\classes\Query;
	use model\classes\Validate;

    /**
     * register a new user in the database. 
     */
    class RegisterController
    {        
        public function __construct(private object $dbcon = DB_CON)
        {

        }

        /* A method of the class `RegisterController` that is called when the user clicks on the
        register button. */
        public function index(): void
        {
			$fields = [];
			$validate = new Validate;           

			try {
				if($_SERVER['REQUEST_METHOD'] === 'POST') {	
					$fields = [
						'user_name'		  => $validate->test_input($_REQUEST['user_name']),
						'password'		  => $validate->test_input($_REQUEST['password']),
						'repeat_password' => $validate->test_input($_REQUEST['repeat_password']),
						'email'			  => $validate->test_input($_REQUEST['email']),
						'terms'			  => isset($_REQUEST['terms']) ? $validate->test_input($_REQUEST['terms']) : ""
					];
					
					if($validate->validate_form($fields)) {
						$query = new Query();

						$rows = $query->selectAllBy("user", "email", $fields['email'], $this->dbcon);
	
						if($fields['password'] !== $fields['repeat_password']) { // compare passwords
							$error_msg = "<p class='error text-center'>Passwords don't match</p>";
						}
						elseif($rows) { // test if email is in use
							$error_msg = "<p class='error text-center'>El email '{$fields['email']}' ya está registrado</p>";																	
						}
						else {
							// save data
							unset($fields['repeat_password']);													
							$query->insertInto('user', $fields);
			
							$success_msg = "<p class='alert alert-success text-center'>El usuario se ha registrado correctamente</p>";
							include(SITE_ROOT . "/../view/database_error.php");
							die;
						}
					}
					else {
						$error_msg = $validate->get_msg();
					}																				
				}

				include(SITE_ROOT . "/../view/register_view.php");

			} catch (\Throwable $th) {			
				$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				include(SITE_ROOT . "/../view/database_error.php");
				die();
			}
        }
    }    
?>