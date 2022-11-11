<?php
	declare(strict_types=1);

	use model\classes\Query;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "register");

	switch($action) {
		case "register":
			$user_name = $_REQUEST['user_name'] ?? "";
			$password = $_REQUEST['password'] ?? "";
			$email = $_REQUEST['email'] ?? "";

			try {
				if (!empty($user_name) && !empty($password) && !empty($email)) {
					$query = new Query();

					$rows = $query->selectAllBy("user", "email", $email, $dbcon);

					if ($rows) {
						$error_msg = "<p class='error'>El email '{$email}' ya está registrado</p>";
						include(SITE_ROOT . "/view/register_view.php");											
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
					include(SITE_ROOT . "/view/register_view.php");	
				}
			} catch (\Throwable $th) {			
				$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
				include(SITE_ROOT . "/view/database_error.php");
				exit();
			}															

			break;			
	}
?>
