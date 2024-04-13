<?php
    namespace model\classes;

    use PDO;

    class Query
    {
        public function __construct(private object $dbcon = DB_CON) {
            
        }
        
        public function selectAllBy(string $table, string $field, string $value, object $dbcon): array  
        {
            $query = "SELECT * FROM $table WHERE $field = :val";                         

            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":val", $value);                            
            $stm->execute();       
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return $rows;
        }

        public function selectOneBy(string $table, string $field, string $value, object $dbcon): array  
        {
            $query = "SELECT * FROM $table WHERE $field = :val";                         

            $stm = $dbcon->pdo->prepare($query);
            $stm->bindValue(":val", $value);                            
            $stm->execute();       
            $rows = $stm->fetch(PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return $rows;
        }

        public function updateRegistry(string $table, string $user_name, string $email, string $id_user, object $dbcon)
        {
            $query = "UPDATE $table SET user_name = :user_name, email = :email WHERE id_user = :id_user";                 

            $stm = $dbcon->pdo->prepare($query); 
            $stm->bindValue(":user_name", $user_name);				
            $stm->bindValue(":email", $email);
            $stm->bindValue(":id_user", $id_user);              
            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
        }

        public function updatePassword(string $table, string $password, string $id_user, object $dbcon)
        {
            $query = "UPDATE $table SET password = :password WHERE id_user = :id_user";                 

            $stm = $dbcon->pdo->prepare($query); 
            $stm->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));				            
            $stm->bindValue(":id_user", $id_user);              
            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
        }

        public function deleteRegistry(string $table, string $id_user, object $dbcon)
        {
            $query = "DELETE FROM $table WHERE id_user = :id_user";                 

            $stm = $dbcon->pdo->prepare($query);             			            
            $stm->bindValue(":id_user", $id_user);              
            $stm->execute();       				
            $stm->closeCursor();
            $dbcon = null;            
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
    }
    
?>