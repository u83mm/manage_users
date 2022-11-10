<?php
	declare(strict_types=1);
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");

	switch($action) {
		case "index":
            $query = "SELECT * FROM user INNER JOIN roles ON user.id_role = roles.id_roles";
            
            $stm = $dbcon->pdo->prepare($query);                                        
            $stm->execute();       
            $rows = $stm->fetchAll();
            $stm->closeCursor();

			include(SITE_ROOT . "/view/admin/index_view.php");		

			break;					
	}
?>