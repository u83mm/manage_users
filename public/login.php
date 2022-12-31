<?php
	declare(strict_types=1);

	use Controller\LoginController;	

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "login");
	$loginController = new LoginController($dbcon);

	switch($action) {
		case "login":			
			$loginController->login();

			break;
			
		case "logout":
			$loginController->logout();

			break;
	}
?>