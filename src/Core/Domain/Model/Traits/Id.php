<?php

	namespace App\Core\Domain\Model\Traits;

	use Doctrine\ORM\Mapping as ORM;
    
    /**
     * Trait Id
     * @package App\Core\Domain\Model\Traits
     */
	trait Id
	{
        
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: 'AUTO')]
        #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
        protected ?int $id = null;

		/**
		 * @return int
		 */
		public function getId() : int
		{
			return (int) $this->id;
		}
	}