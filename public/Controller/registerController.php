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

			if (!empty($user_name) && !empty($password) && !empty($email)) {
				$query = "INSERT INTO user (user_name, password, email) VALUES (:name, :password, :email)";                 

				$stm = $dbcon->pdo->prepare($query); 
				$stm->bindValue(":name", $user_name);
				$stm->bindValue(":password", $password);
				$stm->bindValue(":email", $email);              
				$stm->execute();       				
				$stm->closeCursor();
				$dbcon = null;

				echo "El usuario se ha registrado correctamente";
				exit();
			}
								
			include(SITE_ROOT . "/view/register_view.php");		

			break;			
	}
?>
