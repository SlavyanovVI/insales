<?php
    
    namespace App\Core\Domain\Infrastructure\Repository\Insales\Interface;
    
    use App\Core\Domain\Model;

    /**
     * Interface ApplicationRepositoryInterface
     * @package App\Core\Domain\Infrastructure\Repository\Shop\Interface
     */
    interface ApplicationRepositoryInterface
    {
        /**
         * @param int $id
         * @return Model\Insales\Application|null
         */
        public function find(int $id): ?Model\Insales\Application;
    
        /**
         * @return array|null
         */
        public function findAll(): ?array;
    
        /**
         * @param Model\Insales\Application $shop
         * @return void
         */
        public function add(Model\Insales\Application $shop): void;
    
        /**
         * @param Model\Insales\Application $shop
         * @return void
         */
        public function update(Model\Insales\Application $shop): void;
    
        /**
         * @param Model\Insales\Application $shop
         * @return void
         */
        public function remove(Model\Insales\Application $shop): void;
    
        /**
         * @param int $insalesId
         * @return Model\Insales\Application|null
         */
        public function findOneByInsalesId(int $insalesId): ?Model\Insales\Application;
    
        /**
         * @param string $uuid
         * @return Model\Insales\Application|null
         */
        public function findOneByUuid(string $uuid): ?Model\Insales\Application;
    
        /**
         * Получение приложения у которого не завершен импорт контактов
         * @return Model\Insales\Application|null
         */
        public function findOneNoFinishContactImport(): ?Model\Insales\Application;
    
        /**
         * Получение приложения у которого не завершен импорт заказов
         * @return Model\Insales\Application|null
         */
        public function findOneNoFinishOrderImport(): ?Model\Insales\Application;
    
        /**
         * Получение приложения с готовыми клиентами к выгрузке
         *
         * @return Model\Insales\Application|null
         */
        public function findOneReadyClientExport(): ?Model\Insales\Application;
    }