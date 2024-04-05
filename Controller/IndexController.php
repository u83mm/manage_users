<?php
    declare(strict_types=1);

    class IndexController
    {        
        public function index()
        {
            include(SITE_ROOT . "/../view/main_view.php");
        }
    }    
?>