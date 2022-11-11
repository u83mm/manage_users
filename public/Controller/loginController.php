<?php
	declare(strict_types=1);
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "login");

	switch($action) {
		case "login":						
			include(SITE_ROOT . "/view/login_view.php");		

			break;					
	}
?>