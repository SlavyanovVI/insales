<?php

    namespace App\Core\Application\Command\Insales\Application\InstallApplication;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Core\Domain\Model;
    use App\Core\Ports\Http;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use InSales\API\ApiClient;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Messenger\Attribute\AsMessageHandler;
    use Symfony\Component\Routing\RouterInterface;
	use Symfony\Contracts\HttpClient\HttpClientInterface;
	use Symfony\Contracts\Translation\TranslatorInterface;

	/**
     * Class InstallApplicationCommandHandler
     * @package App\Core\Application\Command\Application\InstallApplication
     */
    #[AsMessageHandler]
    final class InstallApplicationCommandHandler
    {


        /** @var array $options */
        protected array $options;

        public function __construct(
            ParameterBagInterface $parameterBag,
            private readonly ApplicationRepositoryInterface $applicationRepository,
            private readonly RouterInterface $router,
        )
        {

            $this->options = [
                'application_id' => $parameterBag->get('application.insales.application_id'),
                'application_secret' => $parameterBag->get('application.insales.application_secret'),
            ];
        }
    
        /**
         * @param InstallApplicationCommand $command
         * @return Model\Insales\Application
         * @throws BusinessLogicViolationException
         */
        public function __invoke(InstallApplicationCommand $command): Model\Insales\Application
        {
            
            $application = $this->applicationRepository->findOneByInsalesId($command->getInsalesId());
            
            if($application !== null)
            {
                throw new BusinessLogicViolationException(
                    BusinessLogicViolationException::INSTALL_APPLICATION_SHOP_EXISTS
                );
            }

            $application = new Model\Insales\Application();

            $application->setInsalesId($command->getInsalesId())
                ->setUrl($command->getUrl())
                ->setPasswordToken($command->getToken())
                ->setPassword(\md5($command->getToken() . $this->options['application_secret']))
            ;
    
            $this->applicationRepository->add($application);
            
            $apiClient = new ApiClient(
                $this->options['application_id'],
                $application->getPassword(),
                $application->getUrl()
            );
            
            $response = $apiClient->createWebhook(
                [
                    'webhook' => [
                        'address' => $this->router->generate(
                            Http\Webhook\Insales\CreateOrderAction::ROUTE_NAME,
                            [
                                'uuid' => $application->getUuid()
                            ],
                            $this->router::ABSOLUTE_URL
                        ),
                        'topic' => 'orders/create',
                        'format_type' => 'json'
                    ]
                ]
            );
            
            if(!$response->isSuccessful())
            {
                throw new BusinessLogicViolationException(
                    BusinessLogicViolationException::INSTALL_APPLICATION_WEBHOOK_FAIL
                );
            }
            
            $response = $apiClient->createWebhook(
                [
                    'webhook' => [
                        'address' => $this->router->generate(
                            Http\Webhook\Insales\UpdateOrderAction::ROUTE_NAME,
                            [
                                'uuid' => $application->getUuid()
                            ],
                            $this->router::ABSOLUTE_URL
                        ),
                        'topic' => 'orders/update',
                        'format_type' => 'json'
                    ]
                ]
            );
            
            if(!$response->isSuccessful())
            {
                throw new BusinessLogicViolationException(
                    BusinessLogicViolationException::INSTALL_APPLICATION_WEBHOOK_FAIL
                );
            }
            
            return $application;
        }
    }