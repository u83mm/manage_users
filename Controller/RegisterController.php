<?php
    declare(strict_types=1);

	use model\classes\Controller;
	use model\classes\Query;
	use model\classes\Validate;

    /**
     * register a new user in the database. 
     */
    class RegisterController extends Controller
    {        
        public function __construct(
			private object $dbcon = DB_CON,
			private string $message = "",
			private array $fields = []
		)
        {

        }

        /* A method of the class `RegisterController` that is called when the user clicks on the
        register button. */
        public function index(): void
        {			
			$validate = new Validate;           

			try {
				if($_SERVER['REQUEST_METHOD'] === 'POST') {	
					$this->fields = [
						'user_name'		  => $validate->test_input($_REQUEST['user_name']),
						'password'		  => $validate->test_input($_REQUEST['password']),
						'repeat_password' => $validate->test_input($_REQUEST['repeat_password']),
						'email'			  => $validate->test_input($_REQUEST['email']),
						'terms'			  => isset($_REQUEST['terms']) ? $validate->test_input($_REQUEST['terms']) : ""
					];
					
					if($validate->validate_form($this->fields)) {
						$query = new Query();

						$rows = $query->selectAllBy("user", "email", $this->fields['email']);
	
						if($this->fields['password'] !== $this->fields['repeat_password']) { // compare passwords
							$this->message = "<p class='error text-center'>Passwords don't match</p>";
						}
						elseif($rows) { // test if email is in use
							$this->message = "<p class='error text-center'>El email '{$this->fields['email']}' ya está registrado</p>";																	
						}
						else {
							// save data
							unset($this->fields['repeat_password']);													
							$query->insertInto('user', $this->fields);
			
							$this->message = "<p class='alert alert-success text-center'>El usuario se ha registrado correctamente</p>";							
							$this->render("/view/database_error.php", ['message' => $this->message]);							
						}
					}
					else {
						$this->message = $validate->get_msg();
					}																				
				}				

				$this->render("/view/register_view.php", [
					'message'	=>	$this->message,
					'fields'	=>	$this->fields,
				]);

			} catch (\Throwable $th) {			
				$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				
				$this->render("/view/database_error.php", []);				
			}
        }
    }    
?>