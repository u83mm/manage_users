<?php
    namespace Controller;

    use model\classes\Query;
    use model\classes\Validate;

    class AdminController
    {
        private object $dbcon;

        public function __construct(object $dbcon)
        {
            $this->dbcon = $dbcon;
        }

        /** Show user index */
        public function index(): void
        {
            $query = "SELECT * FROM user INNER JOIN roles ON user.id_role = roles.id_roles";
				
            $stm = $this->dbcon->pdo->prepare($query);                                        
            $stm->execute();       
            $rows = $stm->fetchAll();
            $stm->closeCursor();
            //$this->dbcon = null;

            include(SITE_ROOT . "/../view/admin/index_view.php");
        }

        /** Create new user */
        public function new(): void
        {
            $user_name = $_REQUEST['user_name'] ?? "";
				$password = $_REQUEST['password'] ?? "";
				$email = $_REQUEST['email'] ?? "";
	
				try {
					if (!empty($user_name) && !empty($password) && !empty($email)) {
						$query = new Query();
	
						$rows = $query->selectAllBy("user", "email", $email, $this->dbcon);
	
						if ($rows) {
							$error_msg = "<p class='error'>El email '{$email}' ya está registrado</p>";
							include(SITE_ROOT . "/../view/admin/user_new_view.php");											
						}
						else {
							$query = "INSERT INTO user (user_name, password, email) VALUES (:name, :password, :email)";                 
		
							$stm = $this->dbcon->pdo->prepare($query); 
							$stm->bindValue(":name", $user_name);
							$stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
							$stm->bindValue(":email", $email);              
							$stm->execute();       				
							$stm->closeCursor();
							$this->dbcon = null;
			
							$success_msg = "<p>El usuario se ha registrado correctamente</p>";
							include(SITE_ROOT . "/../view/database_error.php");
						}										
					}
					else {
						include(SITE_ROOT . "/../view/admin/user_new_view.php");
					}
				} catch (\Throwable $th) {			
					$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
							de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
					include(SITE_ROOT . "/../view/database_error.php");				
				}			
        }

        public function show(): void
        {
            $id_user = $_REQUEST['id_user'];
	
            $query = new Query();

            try {
                $user = $query->selectOneBy("user", "id_user", $id_user, $this->dbcon);

                include(SITE_ROOT . "/../view/admin/user_show_view.php");
                
            } catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                    de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
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
                $query = new Query();
                $query->updateRegistry("user", $user_name, $email, $id_user, $this->dbcon);

                $success_msg = "<p class='alert alert-success text-center'>Registro actualizado correctamente</p>";

                include(SITE_ROOT . "/../view/database_error.php");

            } catch (\Throwable $th) {			
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
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
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");
            }

            include(SITE_ROOT . "/../view/admin/user_change_password.php");
        }

        /** Deleting a user from the database. */
        public function delete(): void
        {
            $id_user = $_REQUEST['id_user'];
	
            try {
                $query = new Query();
                $query->deleteRegistry("user", $id_user, $this->dbcon);

                $success_msg = "<p class='alert alert-success text-center'>Se ha eliminado el registro</p>";

                include(SITE_ROOT . "/../view/database_error.php");

            } catch (\Throwable $th) {
                $error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
                        de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
                include(SITE_ROOT . "/../view/database_error.php");
            }
        }
    }    
?>