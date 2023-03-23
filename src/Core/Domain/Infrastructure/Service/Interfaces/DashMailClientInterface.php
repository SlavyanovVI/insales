<?php
    
    namespace App\Core\Domain\Infrastructure\Service\Interfaces;
    
    use App\Core\Domain\Model;

    /**
     * Interface DashMailClientInterface
     * @package App\Core\Domain\Infrastructure\Service\Interfaces
     */
    interface DashMailClientInterface
    {
    
        /**
         * Инициализация клиента по приложению
         *
         * @param Model\Insales\Application $application
         * @return mixed
         */
        public function initializeApplication(Model\Insales\Application $application): void;
    
        /**
         * Проверка данные авторизации
         *
         * @param string $login
         * @param string $password
         */
        public function checkAuthentication(string $login, string $password);
    
        /**
         * Создание адресной книги
         *
         * @param array $fields
         * @return int
         */
        public function createAddressBook(array $request): int;
	
		/**
		 * Выгрузка клиентов
		 *
		 * @param array $request
		 * @return void
		 */
		public function createClients(array $request): array;
	
		/**
		 * Обновление клиентов
		 * @param array $request
		 * @return array
		 */
		public function updateClient(array $request): array;
	
		/**
		 * Получение клиента
		 * @param string $email
		 * @param int $listId
		 * @return array
		 */
		public function getClient(string $email, int $listId): array;
    }