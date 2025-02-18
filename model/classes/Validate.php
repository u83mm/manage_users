<?php
    declare(strict_types = 1);
    
    namespace model\classes;
    
    use PDOException;
    use PDO;

    /**
     * Validate inputs
     */
    class Validate
    {
    	private $msg;
    	
        /**
         * Method to validate fields from form
         */
        public function test_input(int|string|float|null $data): int|string|float|null
        {
            if(is_null($data) || ctype_space($data)) return null;            

            if(!is_int($data) && !is_float($data)) {
                $data = htmlspecialchars($data);
                $data = trim($data);
                $data = stripslashes($data);
            }
    
            return $data;
        }
        
        /**
         * Method to validate e-mail fields from form
         */
        function validate_email(string $email): bool {
			if(preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $email)) {
				return true;
			}
			else {
				return false;
			}
		}
		
		/**
         * Método para validar entradas de formulario
         */
        public function validate_form(array $fields): bool
        {
            foreach ($fields as $key => $value) {
                if (empty($value) || !isset($value)) {                                                              
                    $this->msg = "<p class='text-center error'>'" . ucfirst($key) . "' is a required field.</p>";  
                    return false;                                   				
                }                

                if($key === "email" && !$this->validate_email($value)) {
                    $this->msg = "<p class='text-center error'>Insert a valid e-mail.</p>";
                    return false;
                }                
            }
                      
            return true;
        }
        
        /**
         * Show validation messages
         */
        public function get_msg(): string 
        {
            return $this->msg;
        }
    }
?>
