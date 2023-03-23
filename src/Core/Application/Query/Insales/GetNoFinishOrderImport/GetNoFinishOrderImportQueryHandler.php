<?php
    
    namespace App\Core\Application\Query\Insales\GetNoFinishOrderImport;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    #[AsMessageHandler]
    final class GetNoFinishOrderImportQueryHandler
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
         * @param GetNoFinishOrderImportQuery $query
         * @return \App\Core\Domain\Model\Insales\Application|null
         */
        public function __invoke(GetNoFinishOrderImportQuery $query): ?\App\Core\Domain\Model\Insales\Application
        {
            return $this->applicationRepository->findOneNoFinishOrderImport();
        }
    }