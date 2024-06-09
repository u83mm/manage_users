<?php
    declare(strict_types=1);

    use model\classes\AccessControl;
    use model\classes\Controller;
    use model\classes\Query;
    use model\User;
    use model\classes\Validate;
    use Repository\UserRepository;

    class AdminController extends Controller
    {
        use AccessControl;        

        public function __construct(
            private object $dbcon = DB_CON, 
            private string $message = "",
            private array $fields = []
        )
        {
                        
        }

        /** Show user index */
        public function index(): void
        {
            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);
                
                $query = new Query();
                $rows = $query->selectAllInnerjoinByField('user', 'roles', 'id_role');				                             
                
            } catch (\Throwable $th) {
                $this->message = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";					
                $this->render("/view/database_error.php", ['message' => $this->message]);
            }
                        
            $this->render("/view/admin/index_view.php", [
                'message'   =>  $this->message,
                'rows'      =>  $rows
            ]);
        }

        /** Create new user */
        public function new(): void
        {            
            // Define variables						
            $validate = new Validate;

            try {
                // Test access
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);
                
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Get values from the form
                    $this->fields = [
                        'userName'  =>  $validate->test_input($_REQUEST['user_name']),                        
                        'password'	=>	$validate->test_input($_REQUEST['password']),
                        'email'	    =>	$validate->test_input($_REQUEST['email']),
                        'terms'		=>	isset($_REQUEST['terms']) ? $_REQUEST['terms'] : "checked"
                    ];

                    // Validate form
                    if($validate->validate_form($this->fields)) {
                        $query = new Query();
                        $rows = $query->selectAllBy("user", "email", $this->fields['email']);
    
                        if ($rows) {
                            $this->message = "<p class='text-center error'>El email '{$this->fields['email']}' ya está registrado</p>";                            										
                        }
                        else {                              
                            $user = new User($this->fields);
                            $userRepo = new UserRepository();
                            $userRepo->save($user);
                            
                            $this->message = "<p class='alert alert-success text-center'>El usuario se ha registrado correctamente</p>";
                            $this->index();                                                              
                        }                        	
                    }
                    else {
                        $this->message = $validate->get_msg();
                    }                    										
                }
                
                $this->render("/view/admin/user_new_view.php", [
                    'message'   =>  $this->message,
                    'fields'    =>  $this->fields,
                ]);             

            } catch (\Throwable $th) {			
                $this->message = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                $this->render("/view/database_error.php", [
                    'message'   =>  $this->message
                ]);			
            }			
        }

        public function show(string $id = ""): void
        {
            $id_user = $_REQUEST['id_user'] ?? $id;	
            $query = new Query();

            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                $user = $query->selectOneBy("user", "id_user", $id_user, $this->dbcon);

                $this->render("/view/admin/user_show_view.php", [                    
                    'user' =>  $user
                ]);
                
            } catch (\Throwable $th) {
                $this->message = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                $this->render("/view/database_error.php", [
                    'message'   => $this->message
                ]);				
            }	
        }

        /** Update user */
        public function update(): void
        {            
            $validate = new Validate;

            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $user = [
                        'user_name' =>  $validate->test_input($_REQUEST['user_name']),
                        'id_user'   =>  $validate->test_input($_REQUEST['id_user']),
                        'password'  =>  "**************************",
                        'email'     =>  $validate->test_input($_REQUEST['email'])
                    ];
                }

                if($validate->validate_form($user)) {
                    $query = new Query();
                    $query->updateRegistry("user", $user['user_name'], $user['email'], $user['id_user'], $this->dbcon);
    
                    $this->message = "<p class='alert alert-success text-center'>User updated successfully</p>";
                    $this->index();
                }
                else {
                    $this->message = $validate->get_msg();
                    $this->render("/view/admin/user_show_view.php", [
                        'message'   =>  $this->message,
                        'user'      =>  $user
                    ]);
                }               

            } catch (\Throwable $th) {			
                $this->message = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                $this->render("/view/database_error.php", [
                    'message'   =>  $this->message
                ]);				
            }
        }

        /** Change user password */
        public function changePassword(string $id = ""): void
        {            
            $validate = new Validate();
            $query = new Query();	            

            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                $userPassword = $query->selectFieldsFromTableById(["password"], "user", "id_user", $id);                                                 

                $this->fields = [
                    'password'  =>  $userPassword['password'],  
                    'id_user'   =>  $id,                                      
                ];                

                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->fields = [
                        'password'      =>  $validate->test_input($_REQUEST['password']),
                        'id_user'       =>  $id,
                        'new_password'  =>  isset($_REQUEST['new_password']) ? $validate->test_input($_REQUEST['new_password']) : ""
                    ];                                           

                    if($validate->validate_form($this->fields)) {
                        if ($this->fields['password'] !== $this->fields['new_password']) {
                            $this->message = "<p class='alert alert-danger text-center'>Passwords don't match</p>";
                        } else {                            
                            $query->updatePassword("user", $this->fields['new_password'], $this->fields['id_user'], $this->dbcon);
    
                            $this->message = "<p class='alert alert-success text-center'>Password updated</p>";
                        }
                    }
                    else {
                        $this->message = "<p class='alert alert-danger text-center'>You can't let empty fields</p>";
                    } 
                }                
                
                $this->render("/view/admin/user_change_password.php", [
                    'fields'    =>  $this->fields,
                    'message'   =>  $this->message
                ]);

            } catch (\Throwable $th) {
                $this->message = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";

                $this->render("/view/database_error.php", [
                    'message'   =>  $this->message
                ]);
            }            
        }

        /** Deleting a user from the database. */
        public function delete(): void
        {
            $id_user = $_REQUEST['id_user'] ?? "";
	
            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                $query = new Query();
                $query->deleteRegistry("user", $id_user, $this->dbcon);

                $this->message = "<p class='alert alert-success text-center'>Se ha eliminado el registro</p>";                               
                $this->index();

            } catch (\Throwable $th) {
                $this->message = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                $this->render("/view/database_error.php", [
                    'message'   =>  $this->message
                ]);
            }
        }
    }    
?>