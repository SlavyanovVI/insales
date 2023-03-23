<?php
	
	namespace App\Core\Application\Command\Insales\GenerateFailedEmailReport;
	
	use App\Core\Domain\Model;
	
	/**
	 * Генерация отчета с проблемными email адресами
	 *
	 * Class GenerateFailedEmailReportCommand
	 * @package App\Core\Application\Command\Insales\GenerateFailedEmailReport
	 */
	final class GenerateFailedEmailReportCommand
	{
		
		/**
		 * @var Model\Insales\Application
		 */
		private Model\Insales\Application $application;
		
		/**
		 * @var bool
		 */
		private bool $clientWindows = true;
		
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
		 * @return bool
		 */
		public function isClientWindows(): bool
		{
			return $this->clientWindows;
		}
		
		/**
		 * @param bool $clientWindows
		 * @return GenerateFailedEmailReportCommand
		 */
		public function setClientWindows(bool $clientWindows): GenerateFailedEmailReportCommand
		{
			$this->clientWindows = $clientWindows;
			return $this;
		}
	}