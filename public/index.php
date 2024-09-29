<?php
	declare(strict_types=1); 
	
	use \model\classes\App;   

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");
	
	\model\classes\Loader::init(SITE_ROOT . "/..");

    $app = new App;
    $app->router();   
?>
