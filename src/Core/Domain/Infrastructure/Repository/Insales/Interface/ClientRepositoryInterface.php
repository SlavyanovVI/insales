<?php
    
    namespace App\Core\Domain\Infrastructure\Repository\Insales\Interface;
    
    use App\Core\Domain\Model;
    
    /**
     * Interface ClientRepositoryInterface
     * @package App\Core\Domain\Infrastructure\Repository\Insales\Interface
     */
    interface ClientRepositoryInterface
    {
    
        /**
         * @param int $id
         * @return Model\Insales\Client|null
         */
        public function find(int $id): ?Model\Insales\Client;
    
        /**
         * @return array|null
         */
        public function findAll(): ?array;
    
        /**
         * @param Model\Insales\Client $client
         * @return void
         */
        public function add(Model\Insales\Client $client): void;
    
        /**
         * @param Model\Insales\Client $client
         * @return void
         */
        public function update(Model\Insales\Client $client): void;
    
        /**
         * @param Model\Insales\Client $client
         * @return void
         */
        public function remove(Model\Insales\Client $client): void;
    
        /**
         * Получение клиента insales по приложения и внешнему коду клиента
         *
         * @param Model\Insales\Application $application
         * @param string $email
         * @return Model\Insales\Client|null
         */
        public function findOneByApplicationAndClientEmail(Model\Insales\Application $application, string $email):
		?Model\Insales\Client;
    
        /**
         * Получение клиентов по приложению
         *
         * @param Model\Insales\Application $application
         * @return array|null
         */
        public function findByApplication(Model\Insales\Application $application): ?array;
    
        /**
         * Получение количества клиентов готовых к выгрузке
         *
         * @param Model\Insales\Application $application
         * @return int
         */
        public function findCountReadyToExportByApplication(Model\Insales\Application $application): int;
	
		/**
		 * Получение клиентов готовых к выгрузке
		 *
		 * @param Model\Insales\Application $application
		 * @param int|null $limit
		 * @return array|null
		 */
		public function findReadyToExportByApplication(Model\Insales\Application $application, ?int $limit = null):
		?array;
	
		/**
		 * Получение клиентов приложения по email
		 * @param Model\Insales\Application $application
		 * @param string $email
		 * @return array|null
		 */
		public function findByApplicationAndEmail(Model\Insales\Application $application, string $email): ?array;
	
		/**
		 * Количество отклоненных email
		 *
		 * @param Model\Insales\Application $application
		 * @return int
		 */
		public function countBouncedEmailByApplication(Model\Insales\Application $application): int;
	
		/**
		 * Количество одноразовых email
		 *
		 * @param Model\Insales\Application $application
		 * @return int
		 */
		public function countFakeEmailByApplication(Model\Insales\Application $application): int;
		
		/**
		 * Пользователи с отклоненным email
		 *
		 * @param Model\Insales\Application $application
		 * @return null|Model\Insales\Client[]
		 */
		public function findBouncedEmailByApplication(Model\Insales\Application $application): ?array;
		
		/**
		 * Пользователи с одноразовым email
		 *
		 * @param Model\Insales\Application $application
		 * @return null|Model\Insales\Client[]
		 */
		public function findFakeEmailByApplication(Model\Insales\Application $application): ?array;
    }