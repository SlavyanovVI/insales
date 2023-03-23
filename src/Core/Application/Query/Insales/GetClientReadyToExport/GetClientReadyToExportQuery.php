<?php
	
	namespace App\Core\Application\Query\Insales\GetClientReadyToExport;
	
	use App\Core\Domain\Model;
	
	/**
	 * Получение клиентов готовых к экспорту
	 *
	 * Class GetClientReadyToExportQuery
	 * @package App\Core\Application\Query\Insales\GetClientReadyToExport
	 */
	final class GetClientReadyToExportQuery
	{
		
		/**
		 * @var Model\Insales\Application
		 */
		private Model\Insales\Application $application;
		
		/**
		 * @var int
		 */
		private int $limit;
		
		/**
		 * @param Model\Insales\Application $application
		 * @param int $limit
		 */
		public function __construct(Model\Insales\Application $application, int $limit)
		{
			$this->application = $application;
			$this->limit = $limit;
		}
		
		/**
		 * @return Model\Insales\Application
		 */
		public function getApplication(): Model\Insales\Application
		{
			return $this->application;
		}
		
		/**
		 * @return int
		 */
		public function getLimit(): int
		{
			return $this->limit;
		}
	}