<?php
	declare(strict_types=1);

    use Controller\AdminController;    

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");
    $adminController = new AdminController($dbcon);

	$_SESSION['user_name'] ?? $_SESSION['user_name'] = "";
	$_SESSION['role'] ?? $_SESSION['role'] = "";

	if($_SESSION['role'] !== "ROLE_ADMIN") {		
		$error_msg = "<p class='alert alert-danger'>Hola <strong>{$_SESSION['user_name']}</strong>, debes tener privilegios de administrador para realizar esta acción</p>";
		include(SITE_ROOT . "/../view/database_error.php");		
	}
	else {
		switch($action) {
			case "index":
				$adminController->index();	
				break;
				
			case "new":
				$adminController->new();			
				break;
			
			case "show":
				$adminController->show();							
				break;
	
			case "update":
				$adminController->update();	
				break;
	
			case "change password":
				$adminController->changePassword();
				break;
	
			case "delete":
				$adminController->delete();
				break;
		}	
	}	
?>