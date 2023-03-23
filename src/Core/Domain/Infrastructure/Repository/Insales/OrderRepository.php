<?php
    
    namespace App\Core\Domain\Infrastructure\Repository\Insales;

    use App\Core\Domain\Model;
    use Doctrine\ORM\EntityManagerInterface;

    /**
     * Class OrderRepository
     * @package App\Core\Domain\Infrastructure\Repository\Insales
     */
    final class OrderRepository implements Interface\OrderRepositoryInterface
    {
    
        /**
         * @var \Doctrine\ORM\EntityRepository
         */
        private \Doctrine\ORM\EntityRepository $repository;
    
        /**
         * @param EntityManagerInterface $entityManager
         */
        public function __construct(
            private readonly EntityManagerInterface $entityManager
        )
        {
            $this->repository = $this->entityManager->getRepository(Model\Insales\Order::class);
        }
    
        /**
         * @param int $id
         * @return Model\Insales\Order|null
         */
        public function find(int $id): ?Model\Insales\Order
        {
            return $this->repository->find($id);
        }
    
        /**
         * @return array|null
         */
        public function findAll(): ?array
        {
            return $this->repository->findAll();
        }
    
        /**
         * @param Model\Insales\Order $order
         * @return void
         */
        public function add(Model\Insales\Order $order): void
        {
            $this->entityManager->persist($order);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Order $order
         * @return void
         */
        public function update(Model\Insales\Order $order): void
        {
            $this->entityManager->persist($order);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Order $order
         * @return void
         */
        public function remove(Model\Insales\Order $order): void
        {
            $this->entityManager->remove($order);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Application $application
         * @param int $orderId
         * @return Model\Insales\Order|null
         */
        public function findOneByApplicationAndOrderId(Model\Insales\Application $application, int $orderId): ?Model\Insales\Order
        {
            return $this->repository->findOneBy(
                [
                    'application' => $application,
                    'orderId' => $orderId
                ]
            );
        }
	
		/**
		 * @param Model\Insales\Client $client
		 * @return float
		 * @throws \Doctrine\ORM\NoResultException
		 * @throws \Doctrine\ORM\NonUniqueResultException
		 */
        public function getPaymentOrderSumByClient(Model\Insales\Client $client): float
        {
            
            $query = $this->repository->createQueryBuilder('orders');
            
            $query
                ->leftJoin('orders.client', 'client')
                ->select(
                    [
                        'SUM(orders.orderPrice) as sum'
                    ]
                )
                ->where(
                    ($query->expr()->andX())
                        ->add(
                            $query->expr()->eq(
                                'orders.payed',
                                ':payed'
                            )
                        )
                        ->add(
                            $query->expr()->eq(
                                'orders.client',
                                ':client'
                            )
                        )
                )
                ->setParameters(
                    [
                        'payed' => true,
                        'client' => $client
                    ]
                )
            ;
            
            return (double) $query->getQuery()->getSingleScalarResult();
        }
    
        /**
         * @param Model\Insales\Client $client
         * @return int
         * @throws \Doctrine\ORM\NoResultException
         * @throws \Doctrine\ORM\NonUniqueResultException
         */
        public function getPaymentOrderCountByClient(Model\Insales\Client $client): int
        {
            $query = $this->repository->createQueryBuilder('orders');
    
            $query
                ->leftJoin('orders.client', 'client')
                ->select(
                    $query->expr()->count('orders.id')
                )
                ->where(
                    ($query->expr()->andX())
                        ->add(
                            $query->expr()->eq(
                                'orders.payed',
                                ':payed'
                            )
                        )
                        ->add(
                            $query->expr()->eq(
                                'orders.client',
                                ':client'
                            )
                        )
                )
                ->setParameters(
                    [
                        'payed' => true,
                        'client' => $client
                    ]
                )
            ;
    
            return (int) $query->getQuery()->getSingleScalarResult();
        }
	
		/**
		 * @param Model\Insales\Client $client
		 * @return Model\Insales\Order|null
		 */
		public function getFirstPaymentOrderClient(Model\Insales\Client $client): ?Model\Insales\Order
		{
			return $this->repository->findOneBy(
				[
					'client' => $client,
					'payed' => true,
				],
				[
					'createOrderAt' => 'asc',
				]
			);
		}
	
		/**
		 * @param Model\Insales\Client $client
		 * @return Model\Insales\Order|null
		 */
		public function getLastPaymentOrderClient(Model\Insales\Client $client): ?Model\Insales\Order
		{
			return $this->repository->findOneBy(
				[
					'client' => $client,
					'payed' => true,
				],
				[
					'createOrderAt' => 'desc',
				]
			);
		}
	}