<?php		
	model\classes\Loader::init(__DIR__ . "/..");
	
	use Application\Database\Connection;
	
	define('DB_CONFIG_FILE', SITE_ROOT . '/../db.config.php');		
	
	try {
		$dbcon = new Connection(include DB_CONFIG_FILE);
	}
	catch(PDOException $e) {		
		$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$e->getMessage()}</span></p>";
		include(SITE_ROOT . "/view/database_error.php");
		exit();
	}
	catch(Exception $e) {		
		$error_msg = "<p>Hay problemas al conectar con la base de datos, revise la configuración 
						de acceso.</p><p>Descripción del error: <span class='error'>{$e->getMessage()}</span></p>";
		include(SITE_ROOT . "/view/database_error.php");
		exit();
	}			
?>
