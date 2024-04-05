<?php
	declare(strict_types=1); 
	
	use \model\classes\App;   

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");	     

    $app = new App;
    $app->router();   
?>
