<?php

    namespace App\Core\Domain\Model\Traits;

    use Doctrine\ORM\Mapping as ORM;

    #[ORM\HasLifecycleCallbacks]
    trait Uuid
    {

        #[ORM\Column(type: 'guid')]
        protected string $uuid;

        /**
         * @return string
         */
        public function getUuid(): string
        {
            return $this->uuid;
        }

        /**
         * @param string $uuid
         *
         * @return Uuid
         */
        public function setUuid(string $uuid): self
        {
            $this->uuid = $uuid;
            return $this;
        }

        #[ORM\PrePersist]
        public function createUuid(): self
        {
            $this->uuid = \Symfony\Component\Uid\Uuid::v7();
            return $this;
        }
    }
