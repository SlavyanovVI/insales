<?php
    
    namespace App\Core\Application\Query\Insales\GetCountClientReadyToExport;
    
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    #[AsMessageHandler]
    final class GetCountClientReadyToExportQueryHandler
    {
    
        /**
         * @param ClientRepositoryInterface $clientRepository
         */
        public function __construct(
            private readonly ClientRepositoryInterface $clientRepository
        )
        {
        }
    
        /**
         * @param GetCountClientReadyToExportQuery $query
         * @return int
         */
        public function __invoke(GetCountClientReadyToExportQuery $query): int
        {
            return $this->clientRepository->findCountReadyToExportByApplication(
                $query->getApplication()
            );
        }
    }