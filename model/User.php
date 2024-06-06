<?php
    declare(strict_types=1);

    namespace model;

use DateTime;

    class User
    {
        private ?int      $id         = null;
        private ?string   $username   = null;
        private ?string   $password   = null;
        private ?string   $email      = null;
        private ?string   $terms      = null;
        private ?int      $role       = null;
        private ?DateTime $created_at = null;
        

        public function __construct(
            private array $fields = []
        )  
        {
            $this->setUser($this->fields);
        }

        public function setUser(array $fields) : self
        {
            if(!empty($fields)) {
                foreach($fields as $key => $value) {
                    $method = "set" . ucfirst($key);
                    if(method_exists($this, $method)) {
                        $this->$method($value);
                    }
                }
            }

            return $this;
        }

        public function setId(int $id) : self
        {
            $this->id = $id;
            return $this;
        }

        public function setUsername(string $username) : self
        {
            $this->username = $username;
            return $this;
        }

        public function setPassword(string $password) : self
        {
            $this->password = $password;
            return $this;
        }

        public function setEmail(string $email) : self
        {
            $this->email = $email;
            return $this;
        }

        public function setTerms(string $terms) : self
        {
            $this->terms = $terms;
            return $this;
        }

        public function setRole(int $role) : self
        {
            $this->role = $role;
            return $this;
        }

        public function setCreatedAt(DateTime $created_at) : self
        {
            $this->created_at = $created_at;
            return $this;
        }

        public function getId() : ?int
        {
            return $this->id;
        }

        public function getUsername() : ?string
        {
            return $this->username;
        }

        public function getPassword() : ?string
        {
            return $this->password;
        }

        public function getEmail() : ?string
        {
            return $this->email;
        }

        public function getTerms() : ?string
        {
            return $this->terms;
        }

        public function getRole() : ?int
        {
            return $this->role;
        }

        public function getCreatedAt() : ?DateTime
        {
            return $this->created_at;
        }
    }
?>