<?php
    
    namespace App\Core\Domain\Infrastructure\Repository\Insales;

    use App\Core\Domain\Model;
    use Doctrine\ORM\EntityManagerInterface;
    use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;

    /**
     * Class ShopRepository
     * @package App\Core\Domain\Infrastructure\Repository\Shop
     */
    final class ApplicationRepository implements Interface\ApplicationRepositoryInterface
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
            $this->repository = $this->entityManager->getRepository(Model\Insales\Application::class);
        }
    
        /**
         * @param int $id
         * @return Model\Insales\Application|null
         */
        public function find(int $id): ?Model\Insales\Application
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
         * @param Model\Insales\Application $shop
         * @return void
         */
        public function add(Model\Insales\Application $shop): void
        {
            $this->entityManager->persist($shop);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Application $shop
         * @return void
         */
        public function update(Model\Insales\Application $shop): void
        {
            $this->entityManager->persist($shop);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Application $shop
         * @return void
         */
        public function remove(Model\Insales\Application $shop): void
        {
            $this->entityManager->remove($shop);
            $this->entityManager->flush();
        }
    
        public function findOneByInsalesId(int $insalesId): ?Model\Insales\Application
        {
            return $this->repository->findOneBy(
                [
                    'insalesId' => $insalesId
                ]
            );
        }
    
        /**
         * @param string $uuid
         * @return Model\Insales\Application|null
         */
        public function findOneByUuid(string $uuid): ?Model\Insales\Application
        {
            return $this->repository->findOneBy(
                [
                    'uuid' => $uuid
                ]
            );
        }
    
        /**
         * @return Model\Insales\Application|null
         */
        public function findOneNoFinishContactImport(): ?Model\Insales\Application
        {
            return $this->repository->findOneBy(
                [
                    'authentication.authenticationSuccess' => true,
                    'import.clientImportFinish' => false,
                ],
                [
                    'id' => 'asc'
                ]
            );
        }
    
        /**
         * @return Model\Insales\Application|null
         */
        public function findOneNoFinishOrderImport(): ?Model\Insales\Application
        {
            return $this->repository->findOneBy(
                [
                    'import.orderImportFinish' => false,
                    'import.clientImportFinish' => true,
					'authentication.authenticationSuccess' => true,
                ],
                [
                    'id' => 'asc'
                ]
            );
        }
    
        /**
         * @return Model\Insales\Application|null
         * @throws \Doctrine\ORM\NonUniqueResultException
         */
        public function findOneReadyClientExport(): ?Model\Insales\Application
        {
            
            $query = $this->repository->createQueryBuilder('application');
            
            $query->where(
				($query->expr()->andX())
					->add(
						$query->expr()->gt(
							'application.readyExportClient',
							':readyExportClient'
						)
					)
					->add(
						$query->expr()->eq(
							'application.import.orderImportFinish',
							':orderImportFinish'
						)
					)
					->add(
						$query->expr()->eq(
							'application.import.clientImportFinish',
							':clientImportFinish'
						)
					)
					->add(
						$query->expr()->gt(
							'application.options.addressBookId',
							':addressBookId'
						)
					)
				)
                ->setMaxResults(1)
                ->setParameters(
                    [
                        'readyExportClient' => 0,
                        'addressBookId' => 0,
                        'orderImportFinish' => true,
                        'clientImportFinish' => true,
                    ]
                )
                ->orderBy(
                    'application.lastExportDate',
                    'asc'
                )
            ;
            
            return $query->getQuery()->getOneOrNullResult();
        }
    }