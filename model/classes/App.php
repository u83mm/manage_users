<?php
    declare(strict_types=1);

    namespace model\classes;

    class App extends Controller
    {
        public function __construct(
            private string $controllerNamePrefix = "",
            private string $method = "index",
            private string $route = "",
            private string $controllerRoute = "",
            private string $controllerName = "",
            private array $uri = []
        ) {
            $this->controllerNamePrefix = ucfirst('index');            
        }

        public function getUrl() : array|string {
            $uri = explode("/", PATH);
            array_shift($uri);
            return $uri;
        }

        public function router() : void {                                     
            global $id;
            $this->uri = $this->getUrl();                    
                                                 
            try {
                // Test diferent options to configure to Controller                         
                if(count($this->uri) == 1 && !empty($this->uri[0])){
                    $this->controllerNamePrefix = ucfirst($this->uri[0]);
                    $this->method = "index";
                }
                else if(count($this->uri) == 2) {
                    $this->controllerNamePrefix = ucfirst($this->uri[0]);
                    $this->method = $this->uri[1];       
                }
                else if(count($this->uri) > 2) {            
                    if(!empty($this->uri) && preg_match('/^([0-9]){1,5}$/', $this->uri[count($this->uri) - 1])) {
                        $id = $this->uri[count($this->uri) - 1]; 
                        array_pop($this->uri);                                                     
                    }
                    
                    foreach ($this->uri as $key => $value) {
                        if($key == count($this->uri) - 2) break;
                        $this->route .= $value . "/";            
                    }                          
        
                    $this->controllerNamePrefix = ucfirst($this->uri[count($this->uri) - 2]);
                    $this->method = $this->uri[count($this->uri) - 1];                                                       
                } 

                // Build the Controller
                $this->controllerRoute = SITE_ROOT . "/../Controller/" . $this->route;        
                $this->controllerName = $this->controllerNamePrefix . "Controller";                        
               
                $file_name = $this->controllerRoute . $this->controllerName . ".php";
                $params = isset($id) ? ['id' => $id] : [];
                
                if(file_exists($file_name)) {
                    require_once($file_name);

                    $controller = new $this->controllerName;                  
                    call_user_func_array([$controller, $this->method], $params);
                } 
                else {                    
                    throw new \Exception("Page not found");
                }                        
        
            } catch (\Throwable $th) {
                $message = "<p class='alert alert-danger text-center'>Page not found</p>";
        
                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
        
                $this->render("/view/database_error.php", [
                    'message'   =>  $message
                ]);
            }
        }
    }
?>
