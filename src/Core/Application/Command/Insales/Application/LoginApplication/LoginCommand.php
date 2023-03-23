<?php

    namespace App\Core\Application\Command\Insales\Application\LoginApplication;

    /**
     * Class LoginCommand
     * @package App\Core\Application\Command\Application\Login
     */
    final class LoginCommand
    {
        
        /** @var null|int $insalesId */
        protected ?int $insalesId;
        
        /** @var null|string $shop */
        protected ?string $shop;
        
        /** @var string|null $token2 */
        protected ?string $token2;

        /** @var string|null $token3 */
        protected ?string $token3;

        /** @var int|null $userId */
        protected ?int $userId;

        /** @var string|null $userName */
        protected ?string $userName;

        /** @var string|null $userEmail */
        protected ?string $userEmail;

        /** @var string|null $emailConfirmed */
        protected ?string $emailConfirmed;

        /**
         * @return int|null
         */
        public function getInsalesId(): ?int
        {
            return $this->insalesId;
        }

        /**
         * @param null|int $insalesId
         * @return self
         */
        public function setInsalesId(?int $insalesId): self
        {
            $this->insalesId = $insalesId;
            return $this;
        }

        /**
         * @return string|null
         */
        public function getShop(): ?string
        {
            return $this->shop;
        }

        /**
         * @param string|null $shop
         * @return self
         */
        public function setShop(?string $shop): self
        {
            $this->shop = $shop;
            return $this;
        }

        /**
         * @return string|null
         */
        public function getToken2(): ?string
        {
            return $this->token2;
        }

        /**
         * @return string|null
         */
        public function getToken3(): ?string
        {
            return $this->token3;
        }

        /**
         * @param string|null $token3
         * @return self
         */
        public function setToken3(?string $token3): self
        {
            $this->token3 = $token3;
            return $this;
        }

        /**
         * @param string|null $token2
         * @return self
         */
        public function setToken2(?string $token2): self
        {
            $this->token2 = $token2;
            return $this;
        }

        /**
         * @return string|null
         */
        public function getUserEmail(): ?string
        {
            return $this->userEmail;
        }

        /**
         * @param string|null $userEmail
         * @return self
         */
        public function setUserEmail(?string $userEmail): self
        {
            $this->userEmail = $userEmail;
            return $this;
        }

        /**
         * @return string|null
         */
        public function getUserName(): ?string
        {
            return $this->userName;
        }

        /**
         * @param string|null $userName
         * @return self
         */
        public function setUserName(?string $userName): self
        {
            $this->userName = $userName;
            return $this;
        }

        /**
         * @return int|null
         */
        public function getUserId(): ?int
        {
            return $this->userId;
        }

        /**
         * @param int|null $userId
         * @return self
         */
        public function setUserId(?int $userId): self
        {
            $this->userId = $userId;
            return $this;
        }

        /**
         * @return string|null
         */
        public function getEmailConfirmed(): ?string
        {
            return $this->emailConfirmed;
        }

        /**
         * @param string|null $emailConfirmed
         * @return self
         */
        public function setEmailConfirmed(?string $emailConfirmed): self
        {
            $this->emailConfirmed = $emailConfirmed;
            return $this;
        }
    }