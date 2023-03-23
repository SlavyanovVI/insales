<?php
	
	namespace App\Core\Application\Command\Insales\UpdateResultExportClient;
	
	use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
	use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
	use Symfony\Component\Messenger\Attribute\AsMessageHandler;
	
	/**
	 * Class UpdateResultExportClientCommandHandler
	 * @package App\Core\Application\Command\Insales\UpdateResultExportClient
	 */
	#[AsMessageHandler]
	final class UpdateResultExportClientCommandHandler
	{
		
		/**
		 * @param ApplicationRepositoryInterface $applicationRepository
		 * @param ClientRepositoryInterface $clientRepository
		 */
		public function __construct(
			private readonly ApplicationRepositoryInterface $applicationRepository,
			private readonly ClientRepositoryInterface $clientRepository
		)
		{
		}
		
		/**
		 * @param UpdateResultExportClientCommand $command
		 * @return void
		 */
		public function __invoke(UpdateResultExportClientCommand $command): void
		{
			
			$application = $command->getApplication();
			
			$application
				->setBouncedEmailCount($this->clientRepository->countBouncedEmailByApplication($application))
				->setFakeEmailCount($this->clientRepository->countFakeEmailByApplication($application))
			;
			
			$this->applicationRepository->update($application);
		}
	}