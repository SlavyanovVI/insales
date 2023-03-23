<?php
    
    namespace App\Core\Domain\Infrastructure\Repository\Insales;
    
    use App\Core\Domain\Model;
    use Doctrine\ORM\EntityManagerInterface;

    /**
     * Class ClientGroupRepository
     * @package App\Core\Domain\Infrastructure\Repository\Insales
     */
    final class ClientGroupRepository implements Interface\ClientGroupRepositoryInterface
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
            $this->repository = $this->entityManager->getRepository(Model\Insales\ClientGroup::class);
        }
    
        /**
         * @param int $id
         * @return Model\Insales\ClientGroup|null
         */
        public function find(int $id): ?Model\Insales\ClientGroup
        {
            return $this->repository->find($id);
        }
    
        /**
         * @param Model\Insales\ClientGroup $clientGroup
         * @return void
         */
        public function add(Model\Insales\ClientGroup $clientGroup): void
        {
            $this->entityManager->persist($clientGroup);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\ClientGroup $clientGroup
         * @return void
         */
        public function update(Model\Insales\ClientGroup $clientGroup): void
        {
            $this->entityManager->persist($clientGroup);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\ClientGroup $clientGroup
         * @return void
         */
        public function remove(Model\Insales\ClientGroup $clientGroup): void
        {
            $this->entityManager->remove($clientGroup);
            $this->entityManager->flush();
        }
    
        /**
         * @param Model\Insales\Application $application
         * @param int $groupId
         * @return Model\Insales\ClientGroup|null
         */
        public function findOneByApplicationAndGroupId(Model\Insales\Application $application, int $groupId): ?Model\Insales\ClientGroup
        {
            return $this->repository->findOneBy(
                [
                    'application' => $application,
                    'groupId' => $groupId
                ]
            );
        }
    }