<?php

    namespace App\Core\Application\Command\Insales\Application\InstallApplication;

    /**
     * Class InstallApplicationCommand
     * @package App\Core\Application\Command\Application\InstallApplication
     */
    final class InstallApplicationCommand
    {

        /** @var int $insalesId */
        protected int $insalesId;

        /** @var string $url */
        protected string $url;

        /** @var string $token */
        protected string $token;

        /**
         * @param int $insalesId
         * @param string $url
         * @param string $token
         */
        public function __construct(int $insalesId, string $url, string $token)
        {
            $this->insalesId = $insalesId;
            $this->url = $url;
            $this->token = $token;
        }

        /**
         * @return int
         */
        public function getInsalesId(): int
        {
            return $this->insalesId;
        }

        /**
         * @param int $insalesId
         * @return self
         */
        public function setInsalesId(int $insalesId): self
        {
            $this->insalesId = $insalesId;
            return $this;
        }

        /**
         * @return string
         */
        public function getUrl(): string
        {
            return $this->url;
        }

        /**
         * @param string $url
         * @return self
         */
        public function setUrl(string $url): self
        {
            $this->url = $url;
            return $this;
        }

        /**
         * @return string
         */
        public function getToken(): string
        {
            return $this->token;
        }

        /**
         * @param string $token
         * @return self
         */
        public function setToken(string $token): self
        {
            $this->token = $token;
            return $this;
        }
    }