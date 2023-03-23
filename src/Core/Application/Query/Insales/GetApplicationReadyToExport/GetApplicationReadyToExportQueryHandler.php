<?php
    
    namespace App\Core\Application\Query\Insales\GetApplicationReadyToExport;

    use App\Core\Application\Command\Insales\UpdateReadyExportClientCount\UpdateReadyExportClientCountCommand;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use App\Core\Domain\Model;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    #[AsMessageHandler]
    final class GetApplicationReadyToExportQueryHandler
    {
    
        /**
         * @param ApplicationRepositoryInterface $applicationRepository
         */
        public function __construct(
            private readonly ApplicationRepositoryInterface $applicationRepository
        )
        {
        }
    
        /**
         * @param GetApplicationReadyToExportQuery $query
         * @return Model\Insales\Application|null
         */
        public function __invoke(GetApplicationReadyToExportQuery $query): ?Model\Insales\Application
        {
            return $this->applicationRepository->findOneReadyClientExport();
        }
    }