<?php
    
    namespace App\Core\Domain\Model\Insales\Embed;
    
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Embeddable]
    class Options
    {
        
        #[ORM\Column(type: 'bigint', nullable: true, options: ['unsigned' => true, 'default' => null])]
        private ?int $addressBookId = null;
        
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $addressBookTitle = null;
    
        /**
         * @return int|null
         */
        public function getAddressBookId(): ?int
        {
            return $this->addressBookId;
        }
    
        /**
         * @param int|null $addressBookId
         * @return Options
         */
        public function setAddressBookId(?int $addressBookId): Options
        {
            $this->addressBookId = $addressBookId;
            return $this;
        }
    
        /**
         * @return string|null
         */
        public function getAddressBookTitle(): ?string
        {
            return $this->addressBookTitle;
        }
    
        /**
         * @param string|null $addressBookTitle
         * @return Options
         */
        public function setAddressBookTitle(?string $addressBookTitle): Options
        {
            $this->addressBookTitle = $addressBookTitle;
            return $this;
        }
    }