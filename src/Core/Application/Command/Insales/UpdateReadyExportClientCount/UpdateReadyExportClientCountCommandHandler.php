<?php
    
    namespace App\Core\Application\Command\Insales\UpdateReadyExportClientCount;

    use App\Core\Application\Query\Insales\GetCountClientReadyToExport\GetCountClientReadyToExportQuery;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    #[AsMessageHandler]
    final class UpdateReadyExportClientCountCommandHandler
    {
    
        /**
         * @param ApplicationRepositoryInterface $applicationRepository
         * @param HandlerInterface $handler
         */
        public function __construct(
            private readonly ApplicationRepositoryInterface $applicationRepository,
            private readonly HandlerInterface $handler
        )
        {
        }
    
        /**
         * @param UpdateReadyExportClientCountCommand $command
         * @return void
         */
        public function __invoke(UpdateReadyExportClientCountCommand $command): void
        {
            
            $application = $command->getApplication();
            
            $clientCount = $this->handler->handle(
                new GetCountClientReadyToExportQuery(
                    $application
                )
            );

            $application->setReadyExportClient($clientCount);

            $this->applicationRepository->update($application);
        }
    }