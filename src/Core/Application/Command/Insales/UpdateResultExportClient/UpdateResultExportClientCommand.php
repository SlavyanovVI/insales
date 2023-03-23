<?php
	
	namespace App\Core\Application\Command\Insales\UpdateResultExportClient;
	
	use App\Core\Domain\Model;
	
	/**
	 * Обновление результатов выгрузки клиентов
	 *
	 * Class UpdateResultExportClientCommand
	 * @package App\Core\Application\Command\Insales\UpdateResultExportClient
	 */
	final class UpdateResultExportClientCommand
	{
		
		/**
		 * @var Model\Insales\Application
		 */
		private Model\Insales\Application $application;
		
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
	}