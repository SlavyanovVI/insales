<?php

	namespace App\Core\Domain\Model\Traits;

	use Doctrine\ORM\Mapping as ORM;
    
    /**
     * Trait Dates
     * @package App\Core\Domain\Model\Traits
     */
    #[ORM\HasLifecycleCallbacks]
	trait Dates
	{

        #[ORM\Column(type: 'datetime', nullable: true, options: ['default' => null])]
        protected ?\DateTime $createAt = null;
    
        #[ORM\Column(type: 'datetime', nullable: true, options: ['default' => null])]
        protected ?\DateTime $updateAt = null;
    
    
        /**
         * @return \DateTime|null
         */
		public function getCreateAt() : ?\DateTime
		{
			return $this->createAt;
		}

		/**
		 * @param \DateTime $createAt
		 * @return self
		 */
		public function setCreateAt(\DateTime $createAt) : self
		{
			$this->createAt = $createAt;
			return $this;
		}
    
        /**
         * @return \DateTime|null
         */
		public function getUpdateAt() : ?\DateTime
		{
			return $this->updateAt;
		}

		/**
		 * @param \DateTime $updateAt
		 * @return self
		 */
		public function setUpdateAt(\DateTime $updateAt) : self
		{
			$this->updateAt = $updateAt;
			return $this;
		}

		#[ORM\PrePersist]
		public function setDateCreate(): void
        {
			$this->setCreateAt(new \DateTime());
		}
    
        #[ORM\PrePersist]
        #[ORM\PreUpdate]
		public function setDateUpdate(): void
        {
			$this->setUpdateAt(new \DateTime());
		}
	}