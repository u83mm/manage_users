<?php
    namespace Controller;

    class IndexController
    {        
        public function index()
        {
            include(SITE_ROOT . "/../view/main_view.php");
        }
    }    
?>