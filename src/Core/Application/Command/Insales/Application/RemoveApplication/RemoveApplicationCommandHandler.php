<?php

    namespace App\Core\Application\Command\Insales\Application\RemoveApplication;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use App\Shared\Domain\Exception\ResourceNotFoundException;
    use InSales\API\ApiClient;
    use Psr\Log\LoggerInterface;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    /**
     * Class RemoveApplicationCommandHandler
     * @package App\Core\Application\Command\Application\RemoveApplication
     */
    #[AsMessageHandler]
    final class RemoveApplicationCommandHandler
    {
        private array $options;
    
        /**
         * @param ApplicationRepositoryInterface $applicationRepository
         * @param LoggerInterface $logger
         * @param ParameterBagInterface $parameterBag
         */
        public function __construct(
            private readonly ApplicationRepositoryInterface $applicationRepository,
            private readonly LoggerInterface $logger,
            ParameterBagInterface $parameterBag
        )
        {
            $this->options = [
                'application_id' => $parameterBag->get('application.insales.application_id'),
                'application_secret' => $parameterBag->get('application.insales.application_secret'),
            ];
        }
    
        /**
         * @throws ResourceNotFoundException
         * @throws BusinessLogicViolationException
         */
        public function __invoke(RemoveApplicationCommand $command): void
        {

            $application = $this->applicationRepository->findOneByInsalesId(
                $command->getInsalesId()
            );
    
            if($application === null)
            {
        
                $this->logger->critical(ResourceNotFoundException::SHOP_NOT_FOUND);
        
                throw new ResourceNotFoundException(
                    ResourceNotFoundException::SHOP_NOT_FOUND
                );
            }
            
            $apiClient = new ApiClient(
                $this->options['application_id'],
                $application->getPassword(),
                $application->getUrl()
            );
            
            $response = $apiClient->getWebhooks();
            
            if(!$response->isSuccessful())
            {
                throw new BusinessLogicViolationException(
                    BusinessLogicViolationException::REMOVE_APPLICATION_WEBHOOK_FAIL
                );
            }
            
            foreach($response->getData() as $webhook)
            {
                $apiClient->removeWebhook($webhook['id']);
            }

            $this->applicationRepository->remove($application);
        }
    }