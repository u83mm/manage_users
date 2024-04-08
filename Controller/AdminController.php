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

                $query = "SELECT * FROM user INNER JOIN roles USING(id_role)";
				
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
            // define variables			
			$fields = [
                'user_name' => "",				
				'password'	=> "",
                'email'		=> ""
			];

            $validate = new Validate;

            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);
                
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    /** Get values from the form */
                    $fields = [
                        'user_name' =>  $validate->test_input($_REQUEST['user_name']),                        
                        'password'	=>	$validate->test_input($_REQUEST['password']),
                        'email'	    =>	$validate->test_input($_REQUEST['email'])
                    ];

                    /** Validate form */
                    if(!$validate->validate_form($fields)) {
                        $error_msg = $validate->get_msg();	
                    }
                    else {
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
            $user_name = $_REQUEST['user_name'] ?? "";
            $id_user = $_REQUEST['id_user'] ?? "";
            $email = $_REQUEST['email'] ?? "";

            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                if(!empty($user_name) && !empty($id_user) && !empty($email)) {
                    $query = new Query();
                    $query->updateRegistry("user", $user_name, $email, $id_user, $this->dbcon);
    
                    $this->message = "<p class='alert alert-success text-center'>Registro actualizado correctamente</p>";
                    $this->index();
                }
                else {
                    $this->message = "<p class='text-center error'>You must fill all the fields</p>";
                    $this->show();
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
	
            $password = $validate->test_input($_REQUEST['password'] ?? "");
            $id_user = $validate->test_input($_REQUEST['id_user'] ?? "");
            $newPassword = $validate->test_input($_REQUEST['new_password'] ?? "");

            try {
                /** Test access */
                if(!$this->testAccess(['ROLE_ADMIN'])) throw new Exception("You must be admin to access.", 1);

                if (!empty($password) && !empty($id_user) && !empty($newPassword)) {
                    if ($password !== $newPassword) {
                        $error_msg = "<p class='alert alert-danger text-center'>Las contraseñas no son iguales</p>";
                    } else {
                        $query = new Query();
                        $query->updatePassword("user", $newPassword, $id_user, $this->dbcon);

                        $success_msg = "<p class='alert alert-success text-center'>Se ha cambiado la contraseña</p>";
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