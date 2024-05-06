<?php
    declare(strict_types = 1);

    namespace model\classes;

    use DateTime;

    class User
    {
        private string $user_name;
        private string $email;
        private string $password;
        private int $id_role;
        private string $terms;
        private DateTime $created_at;
        public function __construct(private array $fields) { 
            if($fields) {
                foreach($fields as $key => $value) {
                    $method = "set" . ucfirst($key);
                    if(method_exists($this, $method)) {
                        $this->$method($value);
                    }
                }
            }
        }

        public function setUsername(string $user_name): self
        {
            $this->user_name = $user_name;
            return $this;
        }

        public function setEmail(string $email): self
        {
            $this->email = $email;
            return $this;
        }

        public function setPassword(string $password): self
        {
            $this->password = $password;
            return $this;
        }

        public function setTerms(string $terms): self
        {
            $this->terms = $terms;
            return $this;
        }

        public function setCreatedAt(DateTime $created_at): self
        {
            $this->created_at = $created_at;
            return $this;
        }

        public function setRole(int $id_role): self
        {
            $this->id_role = $id_role;
            return $this;
        }

        public function getUserName(): string
        {
            return $this->user_name;
        }

        public function getEmail(): string
        {
            return $this->email;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function getTerms(): string
        {
            return $this->terms;
        }

        public function getCreatedAt(): DateTime
        {
            return $this->created_at;
        }

        public function getRole(): int
        {
            return $this->id_role;
        }
    }
?>