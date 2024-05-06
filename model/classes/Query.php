<?php
    namespace model\classes;

    use PDO;

    class Query
    {
        public function __construct(private object $dbcon = DB_CON) {
            
        }
        
        public function selectAllBy(string $table, string $field, string $value): array  
        {
            $query = "SELECT * FROM $table WHERE $field = :val";                                    

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":val", $value);                            
                $stm->execute();       
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                $stm->closeCursor();
    
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

        public function selectOneBy(string $table, string $field, string $value): array  
        {
            $query = "SELECT * FROM $table WHERE $field = :val";                                     

            try {
                $stm = $this->dbcon->pdo->prepare($query);
                $stm->bindValue(":val", $value);                            
                $stm->execute();       
                $rows = $stm->fetch(PDO::FETCH_ASSOC);
                $stm->closeCursor();

                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

        public function updateRegistry(string $table, string $user_name, string $email, string $id_user)
        {
            $query = "UPDATE $table SET user_name = :user_name, email = :email WHERE id_user = :id_user";                 
                        
            try {
                $stm = $this->dbcon->pdo->prepare($query); 
                $stm->bindValue(":user_name", $user_name);				
                $stm->bindValue(":email", $email);
                $stm->bindValue(":id_user", $id_user);              
                $stm->execute();       				
                $stm->closeCursor();
                
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);
            }
        }

        public function updatePassword(string $table, string $password, string $id_user)
        {
            $query = "UPDATE $table SET password = :password WHERE id_user = :id_user";                 
                        
            try {
                $stm = $this->dbcon->pdo->prepare($query); 
                $stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));				            
                $stm->bindValue(":id_user", $id_user);              
                $stm->execute();       				
                $stm->closeCursor();
                
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1); 
            }
        }

        public function deleteRegistry(string $table, string $id_user)
        {
            $query = "DELETE FROM $table WHERE id_user = :id_user";                             
            
            try {
                $stm = $this->dbcon->pdo->prepare($query);             			            
                $stm->bindValue(":id_user", $id_user);              
                $stm->execute();       				
                $stm->closeCursor();

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1); 
            }
        }

        /**
         * > This function selects all the records from two tables and returns the result as an array
         * 
         * @param string table1 The first table you want to join
         * @param string table2 The table you want to join to.
         * @param string foreignKeyField The field in the first table that is the foreign key to the
         * second table.
         * @param object dbcon The database connection object.
         * 
         * @return array An array of objects.
         */
        public function selectAllInnerjoinByField(string $table1, string $table2, string $foreignKeyField): array
        {
            $query = "SELECT * FROM $table1 
                        INNER JOIN $table2 
                        USING ($foreignKeyField)";
                            
            try {
                $stm = $this->dbcon->pdo->prepare($query);                                                   
                $stm->execute();       
                $rows = $stm->fetchAll();
                $stm->closeCursor();
            
                return $rows;

            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}");
            }
        }

        /**
        * > This function inserts a record into a table
        * 
        * @param array fields an array of fields to be inserted into the database.
        * @param string table The table name
        * @param object dbcon The database connection object.
        */
        public function insertInto(string $table, array $fields): void
        {
            /** Initialice variables */
            $query = $values = "";
            $insert = "INSERT INTO $table (";            

            foreach ($fields as $key => $value) {
                $insert .= $key . ",";
                $values .= ":$key,";
            }

            /** Prepare variables for make the query */
            $insert_size = strlen($insert);
            $insert = substr($insert, 0, $insert_size - 1) . ") VALUES (";          
            $value_size = strlen($values);
            $values = substr($values, 0, $value_size - 1) . ")";

            /** Make the query */
            $query = $insert . $values;            
                                                    
            try {
                $stm = $this->dbcon->pdo->prepare($query);
                foreach ($fields as $key => $value) {
                    if($key === 'password') {
                        $stm->bindValue(":password", password_hash($value, PASSWORD_DEFAULT));
                        continue;
                    }
                    
                    $stm->bindValue(":$key", $value);
                }                   
                $stm->execute();       				
                $stm->closeCursor();
                
            } catch (\Throwable $th) {
                throw new \Exception("{$th->getMessage()}", 1);             
            }
        }
    }
    
?>