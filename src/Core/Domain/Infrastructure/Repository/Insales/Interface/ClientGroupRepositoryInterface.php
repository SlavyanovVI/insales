<?php
    
    namespace App\Core\Domain\Infrastructure\Repository\Insales\Interface;
    
    use App\Core\Domain\Model;

    /**
     * Interface ClientGroupRepositoryInterface
     * @package App\Core\Domain\Infrastructure\Repository\Insales\Interface
     */
    interface ClientGroupRepositoryInterface
    {
    
        /**
         * @param int $id
         * @return Model\Insales\ClientGroup|null
         */
        public function find(int $id): ?Model\Insales\ClientGroup;
    
        /**
         * @param Model\Insales\ClientGroup $clientGroup
         * @return void
         */
        public function add(Model\Insales\ClientGroup $clientGroup): void;
    
        /**
         * @param Model\Insales\ClientGroup $clientGroup
         * @return void
         */
        public function update(Model\Insales\ClientGroup $clientGroup): void;
    
        /**
         * @param Model\Insales\ClientGroup $clientGroup
         * @return void
         */
        public function remove(Model\Insales\ClientGroup $clientGroup): void;
    
        /**
         * Получение группы по приложение и внешнему коду группы
         *
         * @param Model\Insales\Application $application
         * @param int $groupId
         * @return Model\Insales\ClientGroup|null
         */
        public function findOneByApplicationAndGroupId(Model\Insales\Application $application, int $groupId): ?Model\Insales\ClientGroup;
    }