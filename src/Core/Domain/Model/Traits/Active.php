<?php

	namespace App\Core\Domain\Model\Traits;

	use Doctrine\ORM\Mapping as ORM;

    /**
     * Trait Active
     * @package App\Core\Domain\Model\Traits
     */
	trait Active
	{

		/**
		 * @var bool
		 * @ORM\Column(type="boolean")
		 */
		protected bool $active = false;

		/**
		 * @return bool
		 */
		public function isActive() : bool
		{
			return $this->active;
		}

		/**
		 * @param bool $active
		 * @return self
		 */
		public function setActive(bool $active) : self
		{
			$this->active = $active;
			return $this;
		}
	}