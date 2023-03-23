<?php
	
	namespace App\Core\Application\Query\Insales\GetClientReadyToExport;
	
	use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
	use Symfony\Component\Messenger\Attribute\AsMessageHandler;
	
	/**
	 * Class GetClientReadyToExportQueryHandler
	 * @package App\Core\Application\Query\Insales\GetClientReadyToExport
	 */
	#[AsMessageHandler]
	final class GetClientReadyToExportQueryHandler
	{
		
		public function __construct(
			private readonly ClientRepositoryInterface $clientRepository
		)
		{
		}
		
		/**
		 * @param GetClientReadyToExportQuery $query
		 * @return array|null|\App\Core\Domain\Model\Insales\Client[]
		 */
		public function __invoke(GetClientReadyToExportQuery $query): ?array
		{
			return $this->clientRepository->findReadyToExportByApplication(
				$query->getApplication(),
				$query->getLimit()
			);
		}
	}