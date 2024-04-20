<?php
    declare(strict_types=1);

    namespace model\classes;

    class Controller 
    {
        function render(string $path, array $data = []) : void {
            try {
                if($data) extract($data);
    
                require_once(SITE_ROOT . "/.." . $path);
                die;
    
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1); 
            } 
        }
    }    
?>