<?php
    
    namespace App\Core\Application\Command\Application\CalculationPayments;

    use App\Core\Domain\Model;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\OrderRepositoryInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    #[AsMessageHandler]
    final class CalculationPaymentsCommandHandler
    {
    
        /**
         * @param ClientRepositoryInterface $clientRepository
         * @param OrderRepositoryInterface $orderRepository
         */
        public function __construct(
            private readonly ClientRepositoryInterface $clientRepository,
            private readonly OrderRepositoryInterface $orderRepository
        )
        {
        }
    
        /**
         * @param CalculationPaymentsCommand $command
         * @return void
         */
        public function __invoke(CalculationPaymentsCommand $command): void
        {
            
            if($command->getClient() !== null)
            {
                $clients = [$command->getClient()];
            }
            else
            {
                /** @var Model\Insales\Client[]|null $clients */
                $clients = $this->clientRepository->findByApplication(
                    $command->getApplication()
                );
            }

            foreach($clients as $client)
            {
                
                $sum = $this->orderRepository->getPaymentOrderSumByClient($client);
                $count = $this->orderRepository->getPaymentOrderCountByClient($client);
				$firstPayOrder = $this->orderRepository->getFirstPaymentOrderClient($client)?->getCreateOrderAt();
				$lastPayOrder = $this->orderRepository->getLastPaymentOrderClient($client)?->getCreateOrderAt();
                
                if(
                    $client->getPaymentOrder() !== $sum
                    || $client->getPaymentOrderCount() !== $count
					|| $client->getFirstOrderPaymentDate() !== $firstPayOrder
					|| $client->getLastOrderPaymentDate() !== $lastPayOrder
                )
                {
                    
                    $client
                        ->setPaymentOrder($sum)
                        ->setPaymentOrderCount($count)
						->setFirstOrderPaymentDate($firstPayOrder)
						->setLastOrderPaymentDate($lastPayOrder)
                        ->setExported(false)
                    ;
                    
                    $this->clientRepository->update($client);
                }
            }
        }
    }