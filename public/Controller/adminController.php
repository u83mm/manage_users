<?php
	declare(strict_types=1);

	use model\classes\Query;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");

	switch($action) {
		case "index":
            $query = "SELECT * FROM user INNER JOIN roles ON user.id_role = roles.id_roles";
            
            $stm = $dbcon->pdo->prepare($query);                                        
            $stm->execute();       
            $rows = $stm->fetchAll();
            $stm->closeCursor();

			include(SITE_ROOT . "/view/admin/index_view.php");		

			break;
			
		case "new":
			$user_name = $_REQUEST['user_name'] ?? "";
			$password = $_REQUEST['password'] ?? "";
			$email = $_REQUEST['email'] ?? "";

			try {
				if (!empty($user_name) && !empty($password) && !empty($email)) {
					$query = new Query();

					$rows = $query->selectAllBy("user", "email", $email, $dbcon);

					if ($rows) {
						$error_msg = "<p class='error'>El email '{$email}' ya está registrado</p>";
						include(SITE_ROOT . "/view/admin/user_new_view.php");											
					}
					else {
						$query = "INSERT INTO user (user_name, password, email) VALUES (:name, :password, :email)";                 
	
						$stm = $dbcon->pdo->prepare($query); 
						$stm->bindValue(":name", $user_name);
						$stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
						$stm->bindValue(":email", $email);              
						$stm->execute();       				
						$stm->closeCursor();
						$dbcon = null;
		
						$success_msg = "<p>El usuario se ha registrado correctamente</p>";
						include(SITE_ROOT . "/view/database_error.php");
					}										
				}
				else {
					include(SITE_ROOT . "/view/admin/user_new_view.php");
				}
			} catch (\Throwable $th) {			
				$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				include(SITE_ROOT . "/view/database_error.php");				
			}					

			break;
		
		case "show":
				$id_user = $_REQUEST['id_user'];

				$query = new Query();

				try {
					$user = $query->selectOneBy("user", "id_user", $id_user, $dbcon);

					include(SITE_ROOT . "/view/admin/user_show_view.php");
					
				} catch (\Throwable $th) {
					$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
					include(SITE_ROOT . "/view/database_error.php");					
				}								
			break;

		case "update":
			$user_name = $_REQUEST['user_name'] ?? "";
			$id_user = $_REQUEST['id_user'] ?? "";
			$email = $_REQUEST['email'] ?? "";

			try {
				$query = new Query();
				$query->updateRegistry("user", $user_name, $email, $id_user, $dbcon);

				$success_msg = "<p class='alert alert-success text-center'>Registro actualizado correctamente</p>";

				include(SITE_ROOT . "/view/database_error.php");

			} catch (\Throwable $th) {			
				$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				include(SITE_ROOT . "/view/database_error.php");				
			}

			break;
	}
?>