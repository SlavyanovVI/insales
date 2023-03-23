<?php
    
    namespace App\Core\Domain\Model\Insales\Embed;
    
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Embeddable]
    class Authentication
    {
    
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $login;
    
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $password;
    
        #[ORM\Column(type: 'boolean', options: ['default' => false])]
        private bool $authenticationSuccess = false;
    
        #[ORM\Column(type: 'string', length: 500, nullable: true)]
        private ?string $authenticationError;
    
        /**
         * @return string|null
         */
        public function getLogin(): ?string
        {
            return $this->login;
        }
    
        /**
         * @param string|null $login
         * @return Authentication
         */
        public function setLogin(?string $login): Authentication
        {
            $this->login = $login;
            return $this;
        }
    
        /**
         * @return string|null
         */
        public function getPassword(): ?string
        {
            return $this->password;
        }
    
        /**
         * @param string|null $password
         * @return Authentication
         */
        public function setPassword(?string $password): Authentication
        {
            $this->password = $password;
            return $this;
        }
    
        /**
         * @return bool
         */
        public function isAuthenticationSuccess(): bool
        {
            return $this->authenticationSuccess;
        }
    
        /**
         * @param bool $authenticationSuccess
         * @return Authentication
         */
        public function setAuthenticationSuccess(bool $authenticationSuccess): Authentication
        {
            $this->authenticationSuccess = $authenticationSuccess;
            return $this;
        }
    
        /**
         * @return string|null
         */
        public function getAuthenticationError(): ?string
        {
            return $this->authenticationError;
        }
    
        /**
         * @param string|null $authenticationError
         * @return Authentication
         */
        public function setAuthenticationError(?string $authenticationError): Authentication
        {
            $this->authenticationError = $authenticationError;
            return $this;
        }
    
    }