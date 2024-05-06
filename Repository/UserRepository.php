<?php
    declare(strict_types=1);

    namespace Repository;

    use model\classes\Query;
    use model\classes\User;

    class UserRepository extends Query
    {
        public function save(User $user) : void  {
            $fields = [
                'user_name' => $user->getUserName(),                
                'email'     => $user->getEmail(),
                'password'  => $user->getPassword(),
                'terms'     => $user->getTerms()
            ];

            $this->insertInto('user', $fields);            
        }
    }    
?>