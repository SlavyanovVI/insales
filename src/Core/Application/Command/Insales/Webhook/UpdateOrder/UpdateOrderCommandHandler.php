<?php
    
    namespace App\Core\Application\Command\Insales\Webhook\UpdateOrder;

    use App\Core\Domain\Model;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientGroupRepositoryInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\OrderRepositoryInterface;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use InSales\API\ApiClient;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    #[AsMessageHandler]
    final class UpdateOrderCommandHandler
    {
    
        /**
         * @var array
         */
        private array $options;
    
        /**
         * @param OrderRepositoryInterface $orderRepository
         * @param ClientRepositoryInterface $clientRepository
         * @param ClientGroupRepositoryInterface $clientGroupRepository
         * @param ParameterBagInterface $parameterBag
         */
        public function __construct(
            private readonly OrderRepositoryInterface $orderRepository,
            private readonly ClientRepositoryInterface $clientRepository,
            private readonly ClientGroupRepositoryInterface $clientGroupRepository,
            ParameterBagInterface $parameterBag
        )
        {
            $this->options = [
                'application_id' => $parameterBag->get('application.insales.application_id'),
            ];
        }
    
        /**
         * @param UpdateOrderCommand $command
         * @return Model\Insales\Order
         * @throws BusinessLogicViolationException
         */
        public function __invoke(UpdateOrderCommand $command): Model\Insales\Order
        {
            
            $fields = $command->getFields();
            $application = $command->getApplication();
    
            $apiClient = new ApiClient(
                $this->options['application_id'],
                $application->getPassword(),
                $application->getUrl()
            );
            
            $order = $this->orderRepository->findOneByApplicationAndOrderId(
                $application,
                $fields['id']
            );
            
            if($order === null)
            {
                $order = new Model\Insales\Order();
                
                $order->setApplication($application)
                    ->setOrderId($fields['id'])
                ;
            }
            
            if(!empty($fields['client']['id']))
            {
                
                $client = $this->clientRepository->findOneByApplicationAndClientEmail(
                    $application,
                    $fields['client']['email']
                );
                
                if(empty($client))
                {
                    $client = new Model\Insales\Client();
                    
                    $client->setApplication($application)
						->setEmail($fields['client']['email'])
                    ;
                }
                
                $client->setName($fields['client']['name'])
                    ->setMiddlename($fields['client']['middlename'])
                    ->setSurname($fields['client']['surname'])
                    ->setPhone($fields['client']['phone'])
                    ->setClientCreateAt(new \DateTime($fields['client']['created_at']))
					->setExported(false)
                ;
	
				$insalesIds = $client->getClientInsalesIds();
	
				if(!\in_array($fields['client']['id'], $insalesIds))
				{
					$insalesIds[] = $fields['client']['id'];
					$client->setClientInsalesIds($insalesIds);
				}
                
                if(empty($client))
                {
                    throw new BusinessLogicViolationException(
                        BusinessLogicViolationException::UPDATE_ORDER_LOAD_CLIENT_FAIL
                    );
                }
                
                if(!empty($fields['client']['client_group_id']))
                {
    
                    $clientGroups = $apiClient->getClientGroups();
    
                    if(!$clientGroups->isSuccessful())
                    {
                        throw new BusinessLogicViolationException(
                            BusinessLogicViolationException::UPDATE_ORDER_LOAD_CLIENT_GROUP_FAIL
                        );
                    }
    
                    foreach($clientGroups->getData() as $insalesClientGroup)
                    {
                        $clientGroup = $this->clientGroupRepository->findOneByApplicationAndGroupId(
                            $application,
                            $insalesClientGroup['id']
                        );
        
                        if($clientGroup === null)
                        {
            
                            $clientGroup = new Model\Insales\ClientGroup();
            
                            $clientGroup
                                ->setApplication($application)
                                ->setGroupId($insalesClientGroup['id'])
                            ;
                        }
        
                        $clientGroup->setTitle($insalesClientGroup['title']);
        
                        $this->clientGroupRepository->update($clientGroup);
                    }
                    
                    $clientGroup = $this->clientGroupRepository->findOneByApplicationAndGroupId(
                        $application,
                        $fields['client']['client_group_id']
                    );
                    
                    $client->setClientGroup($clientGroup);
                }

				if(
					empty($fields['client']['client_group_id'])
					&& \count($client->getClientInsalesIds()) === 1
				)
				{
					$client->setClientGroup(null);
				}
    
                $this->clientRepository->update($client);
                $order->setClient($client);
            }
    
    
            $order
                ->setPayed($fields['financial_status'] === $order::ORDER_PAYMENT_PAYED)
                ->setOrderNumber($fields['number'])
                ->setOrderPrice((double) $fields['items_price'] + (double) $fields['full_delivery_price'])
                ->setDeliveryPrice((double) $fields['full_delivery_price'])
                ->setCreateOrderAt(new \DateTime($fields['created_at']))
            ;
			
			if(!empty($order->getClient()))
			{
				$order->getClient()
					->setExported(false)
					->setName($fields['client']['name'])
					->setMiddlename($fields['client']['middlename'])
					->setSurname($fields['client']['surname'])
					->setPhone($fields['client']['phone'])
				;
			}
            
            $this->orderRepository->update($order);
            
            return $order;
        }
    }