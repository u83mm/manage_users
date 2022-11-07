<?php
	declare(strict_types=1);
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	if(isset($_POST['action'])) {
		$action = $_POST['action'];
	}
	else if(isset($_GET['action'])) {
		$action = $_GET['action'];
	}
	else {
		$action = "register";
	}

	$action = strtolower($action);

	switch($action) {
		case "register":
			$user_name = $_REQUEST['user_name'] ?? "";
			$password = $_REQUEST['password'] ?? "";
			$email = $_REQUEST['email'] ?? "";

			try {
				if (!empty($user_name) && !empty($password) && !empty($email)) {
					$query = "SELECT * FROM user WHERE email = :val";                         

					$stm = $dbcon->pdo->prepare($query);
					$stm->bindValue(":val", $email);                            
					$stm->execute();       
					$rows = $stm->fetch();
					$stm->closeCursor();

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
