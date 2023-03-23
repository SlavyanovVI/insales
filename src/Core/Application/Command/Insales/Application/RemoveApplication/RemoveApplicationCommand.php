<?php

    namespace App\Core\Application\Command\Insales\Application\RemoveApplication;

    /**
     * Class RemoveApplicationCommand
     * @package App\Core\Application\Command\Application\RemoveApplication
     */
    final class RemoveApplicationCommand
    {

        /** @var int $insalesId */
        protected int $insalesId;

        /**
         * @param int $insalesId
         */
        public function __construct(int $insalesId)
        {
            $this->insalesId = $insalesId;
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
    }