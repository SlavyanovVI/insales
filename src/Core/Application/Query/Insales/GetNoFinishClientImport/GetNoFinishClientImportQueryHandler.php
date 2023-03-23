<?php
    
    namespace App\Core\Application\Query\Insales\GetNoFinishClientImport;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Core\Domain\Model;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    #[AsMessageHandler]
    final class GetNoFinishClientImportQueryHandler
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
         * @param GetNoFinishClientImportQuery $command
         * @return Model\Insales\Application|null
         */
        public function __invoke(GetNoFinishClientImportQuery $command): ?Model\Insales\Application
        {
            return $this->applicationRepository->findOneNoFinishContactImport();
        }
    }