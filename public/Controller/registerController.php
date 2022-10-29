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
			include(SITE_ROOT . "/view/register_view.php");		

			break;			
	}
?>
