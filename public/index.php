<?php
	declare(strict_types=1);

	use Controller\IndexController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		
	
	$indexController = new IndexController();
	$indexController->index();
?>
