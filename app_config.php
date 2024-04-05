<?php	
	define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']);

	/** Define connection */
	require_once(SITE_ROOT . "/../model/connect.php");
	define('DB_CON', $dbcon);

	/** Define current URL */
	define('PATH', rtrim($_SERVER['REQUEST_URI'], "/"));

	session_start();
	session_regenerate_id();
?>
