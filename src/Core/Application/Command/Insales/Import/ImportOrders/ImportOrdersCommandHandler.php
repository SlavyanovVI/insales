<?php
    
    namespace App\Core\Application\Command\Insales\Import\ImportOrders;
    
    use App\Core\Application\Command\Application\CalculationPayments\CalculationPaymentsCommand;
	use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\OrderRepositoryInterface;
    use App\Core\Domain\Model;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
	use InSales\API\ApiClient;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;
	use Symfony\Component\Messenger\MessageBusInterface;

	#[AsMessageHandler]
    final class ImportOrdersCommandHandler
    {
    
        /**
         * @var array
         */
        private array $options;
    
        /** @var int Лимит загрузки заказов из insales на один запрос */
        private const LOAD_ORDER_LIMIT = 100;
        
        /** @var int Лимит шагов загрузки за 1 раз */
        private const LOAD_ORDER_PAGE_LIMIT = 1;
		
		/**
		 * @param ParameterBagInterface $parameterBag
		 * @param MessageBusInterface $messageBus
		 * @param OrderRepositoryInterface $orderRepository
		 * @param ClientRepositoryInterface $clientRepository
		 * @param ApplicationRepositoryInterface $applicationRepository
		 */
        public function __construct(
            ParameterBagInterface $parameterBag,
			private readonly MessageBusInterface $messageBus,
            private readonly OrderRepositoryInterface $orderRepository,
            private readonly ClientRepositoryInterface $clientRepository,
            private readonly ApplicationRepositoryInterface $applicationRepository
        )
        {
            $this->options = [
                'application_id' => $parameterBag->get('application.insales.application_id')
            ];
        }
    
        /**
         * @param ImportOrdersCommand $command
         * @return void
         * @throws BusinessLogicViolationException
         */
        public function __invoke(ImportOrdersCommand $command): void
        {
            
            $application = $command->getApplication();
    
            $apiClient = new ApiClient(
                $this->options['application_id'],
                $application->getPassword(),
                $command->getApplication()->getUrl()
            );

            $ordersCount = $apiClient->getOrdersCount();
            
            if(!$ordersCount->isSuccessful())
            {
                throw new BusinessLogicViolationException(
                    BusinessLogicViolationException::IMPORT_ORDER_LOAD_FAIL
                );
            }
            
            $insalesOrders = [];
            $stepCount = 0;
            $pagesCount = (int) \ceil($ordersCount->getData()['count'] / self::LOAD_ORDER_LIMIT);
            
            if($pagesCount === $application->getImport()->getLastOrderPage())
            {
                $application->getImport()->setOrderImportFinish(true);
                $this->applicationRepository->update($application);
            }
            
            for($page = $application->getImport()->getLastOrderPage(); $page <= $pagesCount; $page++)
            {
    
                $application->getImport()->setLastOrderPage($page);
                
                $filter = [
                    'per_page' => self::LOAD_ORDER_LIMIT,
                    'page' => $page,
                ];

                $response = $apiClient->getOrders($filter);

                if(!$response->isSuccessful())
                {
                    throw new BusinessLogicViolationException(
                        BusinessLogicViolationException::IMPORT_ORDER_LOAD_FAIL
                    );
                }

                foreach($response->getData() as $order)
                {

                    if(
						empty($order['client'])
						|| empty($order['client']['email'])
					)
                    {
                        continue;
                    }
	
					/**
					 * Только оплаченные заказы
					 */
//                    if($order['financial_status'] !== Model\Insales\Order::ORDER_PAYMENT_PAYED)
//                    {
//                        continue;
//                    }

                    $insalesOrders[] = [
                        'id' => $order['id'],
                        'client' => $order['client']['email'],
                        'financial_status' => $order['financial_status'],
                        'order_price' => $order['items_price'],
                        'delivery_price' => $order['full_delivery_price'],
                        'number' => $order['number'],
                        'created_at' => $order['created_at'],
                    ];
                }

                if((++$stepCount) > self::LOAD_ORDER_PAGE_LIMIT)
                {
                    break;
                }
            }
    
            $this->applicationRepository->update($application);

            foreach($insalesOrders as $insalesOrder)
            {

                $order = $this->orderRepository->findOneByApplicationAndOrderId(
                    $application,
                    $insalesOrder['id']
                );

                if($order === null)
                {

                    $order = new Model\Insales\Order();

                    $order->setApplication($application)
                        ->setOrderId($insalesOrder['id'])
                    ;
                }

                $client = $this->clientRepository->findOneByApplicationAndClientEmail(
                    $application,
                    $insalesOrder['client']
                );

                if($client === null)
                {
                    continue;
                }

                $order
                    ->setPayed($insalesOrder['financial_status'] === $order::ORDER_PAYMENT_PAYED)
                    ->setOrderNumber($insalesOrder['number'])
                    ->setOrderPrice((double) $insalesOrder['order_price'] + (double) $insalesOrder['delivery_price'])
                    ->setDeliveryPrice((double) $insalesOrder['delivery_price'])
                    ->setClient($client)
                    ->setCreateOrderAt(new \DateTime($insalesOrder['created_at']))
                ;

                $this->orderRepository->add($order);
            }
			
			$this->messageBus->dispatch(
				new CalculationPaymentsCommand(
					$application
				)
			);
        }
    }