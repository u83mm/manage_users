<?php
    declare(strict_types=1);

    use model\classes\AccessControl;
    use model\classes\Query;
    use model\classes\Validate;

    class AdminController
    {
        use AccessControl;        

        public function __construct(private object $dbcon = DB_CON, private string $message = "")
        {
                        
        }

        /** Show user index */
        public function index(): void
        {
            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                $query = "SELECT * FROM user INNER JOIN roles USING(id_role) ORDER BY id_user";
				
                $stm = $this->dbcon->pdo->prepare($query);                                        
                $stm->execute();       
                $rows = $stm->fetchAll();
                $stm->closeCursor();                
                
            } catch (\Throwable $th) {
                $error_msg = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
					include(SITE_ROOT . "/../view/database_error.php");
            }
            
            include(SITE_ROOT . "/../view/admin/index_view.php");
        }

        /** Create new user */
        public function new(): void
        {            
            // Define variables			
			$fields = [];
            $validate = new Validate;

            try {
                // Test access
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);
                
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Get values from the form
                    $fields = [
                        'user_name' =>  $validate->test_input($_REQUEST['user_name']),                        
                        'password'	=>	$validate->test_input($_REQUEST['password']),
                        'email'	    =>	$validate->test_input($_REQUEST['email'])
                    ];

                    // Validate form
                    if($validate->validate_form($fields)) {
                        $query = new Query();
                        $rows = $query->selectAllBy("user", "email", $fields['email'], $this->dbcon);
    
                        if ($rows) {
                            $error_msg = "<p class='text-center error'>El email '{$fields['email']}' ya está registrado</p>";                            										
                        }
                        else {
                            $query = "INSERT INTO user (user_name, password, email) VALUES (:name, :password, :email)";                 
        
                            $stm = $this->dbcon->pdo->prepare($query); 
                            $stm->bindValue(":name", $fields['user_name']);
                            $stm->bindValue(":password", password_hash($fields['password'], PASSWORD_DEFAULT));
                            $stm->bindValue(":email", $fields['email']);              
                            $stm->execute();       				
                            $stm->closeCursor();                        
            
                            $this->message = "<p class='alert alert-success text-center'>El usuario se ha registrado correctamente</p>";
                            $this->index();
                            die;
                        }                        	
                    }
                    else {
                        $error_msg = $validate->get_msg();
                    }                    										
                }

                include(SITE_ROOT . "/../view/admin/user_new_view.php");                

            } catch (\Throwable $th) {			
                $error_msg = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");				
            }			
        }

        public function show(): void
        {
            $id_user = $_REQUEST['id_user'] ?? "";	
            $query = new Query();

            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                $user = $query->selectOneBy("user", "id_user", $id_user, $this->dbcon);

                include(SITE_ROOT . "/../view/admin/user_show_view.php");
                
            } catch (\Throwable $th) {
                $error_msg = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");					
            }	
        }

        /** Update user */
        public function update(): void
        {
            $user = [];
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
                    include(SITE_ROOT . "/../view/admin/user_show_view.php");
                }               

            } catch (\Throwable $th) {			
                $error_msg = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");				
            }
        }

        /** Change user password */
        public function changePassword(): void
        {            
            $validate = new Validate();	            

            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $fields = [
                        'password'      =>  $validate->test_input($_REQUEST['password']),
                        'id_user'       =>  $validate->test_input($_REQUEST['id_user']),
                        'new_password'  =>  isset($_REQUEST['new_password']) ? $validate->test_input($_REQUEST['new_password']) : ""
                    ];
                }

                if($validate->validate_form($fields)) {
                    if ($fields['password'] !== $fields['new_password']) {
                        $error_msg = "<p class='alert alert-danger text-center'>Passwords don't match</p>";
                    } else {
                        $query = new Query();
                        $query->updatePassword("user", $fields['new_password'], $fields['id_user'], $this->dbcon);

                        $success_msg = "<p class='alert alert-success text-center'>Password updated</p>";
                    }
                }
            } catch (\Throwable $th) {
                $error_msg = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");
            }

            include(SITE_ROOT . "/../view/admin/user_change_password.php");
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

                $success_msg = "<p class='alert alert-success text-center'>Se ha eliminado el registro</p>";

                //include(SITE_ROOT . "/../view/database_error.php");
                $this->message = $success_msg;
                $this->index();

            } catch (\Throwable $th) {
                $error_msg = "<p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");
            }
        }
    }    
?>