<?php
    declare(strict_types=1);

    use model\classes\Controller;

    class IndexController extends Controller
    {        
        public function index()
        {            
            $this->render("/view/main_view.php", []);
        }
    }    
?>