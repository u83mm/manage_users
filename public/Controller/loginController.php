<?php
	declare(strict_types=1);
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "login");

	switch($action) {
		case "login":
			// recogemos los datos del formulario
			$email = $_REQUEST['email'] ?? "";
			$password = $_REQUEST['password'] ?? "";			

			if(!isset($_SESSION['id_user'])) {	
				if(!empty($email) && !empty($password)) {
					// hacemos la consulta a la DB				
					$query = "SELECT * FROM user INNER JOIN roles ON user.id_role = roles.id_roles WHERE email = :val";

					try {
						$stm = $dbcon->pdo->prepare($query);
						$stm->bindValue(":val", $email);				
						$stm->execute();					

						// si encuentra el usuario en la DB
						if($stm->rowCount() == 1) {
							$result = $stm->fetch(PDO::FETCH_ASSOC);					
							
							// comprueba que la contraseña introducida coincide con la de la DB
							if(password_verify($password, $result['password'])) {												
								$_SESSION['id_user'] = $result['id_user'];						
								$_SESSION['user_name'] = $result['user_name'];
								$_SESSION['role'] = $result['role'];												
								$stm->closeCursor();
								header("Location: /Controller/adminController.php");											
							}
							else {
								$error_msg = "<p class='error'>Tu usuario y contraseña no coinciden</p>";
								include(SITE_ROOT . "/view/login_view.php");
							}			
						}
						else {		
							$error_msg = "<p class='error'>El usuario \"{$email}\" no existe en la base de datos</p>";										
							include(SITE_ROOT . "/view/login_view.php");
						}
					} catch (\Throwable $th) {					
						$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
							de acceso.</p><p>Descripción del error: <span class='error'>{$th->getMessage()}</span></p>";
						include(SITE_ROOT . "/view/database_error.php");				
					}	
				}									
			}
			else {		
				header("Location: /Controller/adminController.php");
			}			
			
			include(SITE_ROOT . "/view/login_view.php");		

			break;
			
		case "logout":
			unset($_SESSION['id_user']);
			unset($_SESSION['user_name']);
			unset($_SESSION['role']);
		  
			$_SESSION = array();
		  
			session_destroy();
			setcookie('PHPSESSID', "0", time() - 3600);
		  
			header("Location: /Controller/loginController.php");

			break;
	}
?>