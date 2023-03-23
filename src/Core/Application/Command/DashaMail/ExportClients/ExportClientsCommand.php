<?php
	
	namespace App\Core\Application\Command\DashaMail\ExportClients;
	
	use App\Core\Domain\Model;
	
	/**
	 * Выгрузка клиентов по приложению
	 *
	 * Class ExportClientsCommand
	 * @package App\Core\Application\Command\DashaMail\ExportClients
	 */
	final class ExportClientsCommand
	{
		
		/**
		 * @var Model\Insales\Application
		 */
		private Model\Insales\Application $application;
		
		/**
		 * @var int|null
		 */
		private ?int $limit = null;
		
		/**
		 * @param Model\Insales\Application $application
		 */
		public function __construct(Model\Insales\Application $application)
		{
			$this->application = $application;
		}
		
		/**
		 * @return Model\Insales\Application
		 */
		public function getApplication(): Model\Insales\Application
		{
			return $this->application;
		}
		
		/**
		 * @return int|null
		 */
		public function getLimit(): ?int
		{
			return $this->limit;
		}
		
		/**
		 * @param int|null $limit
		 * @return ExportClientsCommand
		 */
		public function setLimit(?int $limit): ExportClientsCommand
		{
			$this->limit = $limit;
			return $this;
		}
	}