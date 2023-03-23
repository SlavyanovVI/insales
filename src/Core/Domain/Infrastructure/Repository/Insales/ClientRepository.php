<?php
    
    namespace App\Core\Domain\Infrastructure\Repository\Insales;
    
    use App\Core\Domain\Model;
    use Doctrine\ORM\EntityManagerInterface;

    /**
     * Class ClientRepository
     * @package App\Core\Domain\Infrastructure\Repository\Insales
     */
    final class ClientRepository implements Interface\ClientRepositoryInterface
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
            $this->repository = $this->entityManager->getRepository(Model\Insales\Client::class);
        }
    
        /**
         * @param int $id
         * @return Model\Insales\Client|null
         */
        public function find(int $id): ?Model\Insales\Client
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
         * @param Model\Insales\Client $client
         * @return void
         */
        public function add(Model\Insales\Client $client): void
        {
            $this->entityManager->persist($client);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Client $client
         * @return void
         */
        public function update(Model\Insales\Client $client): void
        {
            $this->entityManager->persist($client);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Client $client
         * @return void
         */
        public function remove(Model\Insales\Client $client): void
        {
            $this->entityManager->remove($client);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Application $application
         * @param string $email
         * @return Model\Insales\Client|null
         */
        public function findOneByApplicationAndClientEmail(Model\Insales\Application $application, string $email):
		?Model\Insales\Client
        {
            return $this->repository->findOneBy(
                [
                    'application' => $application,
                    'email' => $email
                ]
            );
        }
    
        /**
         * @param Model\Insales\Application $application
         * @return array|null
         */
        public function findByApplication(Model\Insales\Application $application): ?array
        {
            return $this->repository->findBy(
                [
                    'application' => $application
                ]
            );
        }
    
        /**
         * @param Model\Insales\Application $application
         * @return int
         */
        public function findCountReadyToExportByApplication(Model\Insales\Application $application): int
        {
            
            $query = $this->repository->createQueryBuilder('client');
            
            $query
                ->select(
                    $query->expr()->countDistinct('client.email')
                )
                ->where(
                    ($query->expr()->andX())
                        ->add(
                            $query->expr()->eq(
                                'client.application',
                                ':application'
                            )
                        )
                        ->add(
                            $query->expr()->eq(
                                'client.exported',
                                ':exported'
                            )
                    	)
						->add(
							$query->expr()->isNotNull('client.email')
						)
                )
                ->setParameters(
                    [
                        'application' => $application,
                        'exported' => false,
                    ]
                )
            ;
            
            return (int) $query->getQuery()->getSingleScalarResult();
        }
	
		/**
		 * @param Model\Insales\Application $application
		 * @param int|null $limit
		 * @return array|null
		 */
		public function findReadyToExportByApplication(Model\Insales\Application $application, ?int $limit = null): ?array
		{
			
			$query = $this->repository->createQueryBuilder('client');
			
			$query
				->where(
					($query->expr()->andX())
						->add(
							$query->expr()->eq(
								'client.application',
								':application'
							)
						)
						->add(
							$query->expr()->eq(
								'client.exported',
								':exported'
							)
						)
						->add(
							$query->expr()->isNotNull('client.email')
						)
				)
				->setParameters(
					[
						'application' => $application,
						'exported' => false,
					]
				)
				->orderBy(
					'client.updateAt',
					'asc'
				)
			;
			
			if(!empty($limit))
			{
				$query->setMaxResults($limit);
			}
			
			return $query->getQuery()->getResult();
		}
	
		/**
		 * @param Model\Insales\Application $application
		 * @param string $email
		 * @return array|null
		 */
		public function findByApplicationAndEmail(Model\Insales\Application $application, string $email): ?array
		{
			return $this->repository->findBy(
				[
					'application' => $application,
					'email' => $email
				]
			);
		}
	
		/**
		 * @param Model\Insales\Application $application
		 * @return int
		 * @throws \Doctrine\ORM\NoResultException
		 * @throws \Doctrine\ORM\NonUniqueResultException
		 */
		public function countBouncedEmailByApplication(Model\Insales\Application $application): int
		{
			$query = $this->repository->createQueryBuilder('client');
			
			$query
				->select(
					$query->expr()->count('client.email')
				)
				->where(
					($query->expr()->andX())
						->add(
							$query->expr()->eq(
								'client.application',
								':application'
							)
						)
						->add(
							$query->expr()->eq(
								'client.dashaMailBouncedEmail',
								':dashaMailBouncedEmail'
							)
						)
				)
				->setParameters(
					[
						'application' => $application,
						'dashaMailBouncedEmail' => true,
					]
				)
			;
			
			return (int) $query->getQuery()->getSingleScalarResult();
		}
	
		/**
		 * @param Model\Insales\Application $application
		 * @return int
		 * @throws \Doctrine\ORM\NoResultException
		 * @throws \Doctrine\ORM\NonUniqueResultException
		 */
		public function countFakeEmailByApplication(Model\Insales\Application $application): int
		{
			$query = $this->repository->createQueryBuilder('client');
			
			$query
				->select(
					$query->expr()->count('client.email')
				)
				->where(
					($query->expr()->andX())
						->add(
							$query->expr()->eq(
								'client.application',
								':application'
							)
						)
						->add(
							$query->expr()->eq(
								'client.dashaMailFakeEmail',
								':dashaMailFakeEmail'
							)
						)
				)
				->setParameters(
					[
						'application' => $application,
						'dashaMailFakeEmail' => true,
					]
				)
			;
			
			return (int) $query->getQuery()->getSingleScalarResult();
		}
	
		/**
		 * @param Model\Insales\Application $application
		 * @return array|Model\Insales\Client[]|null
		 */
		public function findBouncedEmailByApplication(Model\Insales\Application $application): ?array
		{
			return $this->repository->findBy(
				[
					'application' => $application,
					'dashaMailBouncedEmail' => true,
				]
			);
		}
	
		/**
		 * @param Model\Insales\Application $application
		 * @return array|Model\Insales\Client[]|null
		 */
		public function findFakeEmailByApplication(Model\Insales\Application $application): ?array
		{
			return $this->repository->findBy(
				[
					'application' => $application,
					'dashaMailFakeEmail' => true,
				]
			);
		}
	}