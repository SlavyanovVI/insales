<?php
    
    namespace App\Core\Application\Command\Insales\SaveApplication;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    #[AsMessageHandler]
    final class SaveApplicationCommandHandler
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
         * @param SaveApplicationCommand $command
         * @return void
         */
        public function __invoke(SaveApplicationCommand $command): void
        {
            $this->applicationRepository->update(
                $command->getApplication()
            );
        }
    }