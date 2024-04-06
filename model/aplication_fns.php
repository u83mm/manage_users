<?php	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/my_functions.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/classes/Loader.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../app_config.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/connect.php"); //Descomentar si vamos a usar consultas a DB.
	
	// Required files to clean logs in the local server
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/Cron_jobs/clean_access_log.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/Cron_jobs/clean_error_log.php");
?>
