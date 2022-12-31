<?php
	declare(strict_types=1);

    use Controller\RegisterController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		
	
	$registerController = new RegisterController($dbcon);

    $registerController->register();
?>