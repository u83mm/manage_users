<?php
    namespace model\classes;

    use PDO;

    class Query
    {
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
    }
    
?>