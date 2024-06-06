<?php
    declare(strict_types=1);

    namespace Repository;

    use model\classes\Query;
    use model\User;

    class UserRepository extends Query
    {
        public function save(User $user) : void  {
            $fields = [
                'user_name' => $user->getUsername(),                
                'email'     => $user->getEmail(),
                'password'  => $user->getPassword(),
                'terms'     => $user->getTerms()
            ];            

            $this->insertInto('user', $fields);            
        }
    }    
?>