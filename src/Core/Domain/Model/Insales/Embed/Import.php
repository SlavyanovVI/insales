<?php
    
    namespace App\Core\Domain\Model\Insales\Embed;
    
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Embeddable]
    class Import
    {
    
        #[ORM\Column(type: 'boolean', options: ['default' => false])]
        private bool $orderImportFinish = false;
    
        #[ORM\Column(type: 'boolean', options: ['default' => false])]
        private bool $clientImportFinish = false;
    
        #[ORM\Column(type: 'integer', options: ['unsigned' => true, 'default' => 1])]
        private int $lastOrderPage = 1;
    
        /**
         * @return bool
         */
        public function isOrderImportFinish(): bool
        {
            return $this->orderImportFinish;
        }
    
        /**
         * @param bool $orderImportFinish
         * @return Import
         */
        public function setOrderImportFinish(bool $orderImportFinish): Import
        {
            $this->orderImportFinish = $orderImportFinish;
            return $this;
        }
    
        /**
         * @return bool
         */
        public function isClientImportFinish(): bool
        {
            return $this->clientImportFinish;
        }
    
        /**
         * @param bool $clientImportFinish
         * @return Import
         */
        public function setClientImportFinish(bool $clientImportFinish): Import
        {
            $this->clientImportFinish = $clientImportFinish;
            return $this;
        }
    
        /**
         * @return int
         */
        public function getLastOrderPage(): int
        {
            return $this->lastOrderPage;
        }
    
        /**
         * @param int $lastOrderPage
         * @return Import
         */
        public function setLastOrderPage(int $lastOrderPage): Import
        {
            $this->lastOrderPage = $lastOrderPage;
            return $this;
        }
    }