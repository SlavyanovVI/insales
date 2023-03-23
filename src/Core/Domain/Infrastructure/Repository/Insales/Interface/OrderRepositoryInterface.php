<?php
    
    namespace App\Core\Domain\Infrastructure\Repository\Insales\Interface;
    
    use App\Core\Domain\Model;

    /**
     * Interface OrderRepositoryInterface
     * @package App\Core\Domain\Infrastructure\Repository\Shop\Interface
     */
    interface OrderRepositoryInterface
    {
    
        /**
         * @param int $id
         * @return Model\Insales\Order|null
         */
        public function find(int $id): ?Model\Insales\Order;
    
        /**
         * @return array|null
         */
        public function findAll(): ?array;
    
        /**
         * @param Model\Insales\Order $order
         * @return void
         */
        public function add(Model\Insales\Order $order): void;
    
        /**
         * @param Model\Insales\Order $order
         * @return void
         */
        public function update(Model\Insales\Order $order): void;
    
        /**
         * @param Model\Insales\Order $order
         * @return void
         */
        public function remove(Model\Insales\Order $order): void;
    
        /**
         * Получение заказа по приложению и внешнему номеру заказа
         *
         * @param Model\Insales\Application $application
         * @param int $orderId
         * @return Model\Insales\Order|null
         */
        public function findOneByApplicationAndOrderId(Model\Insales\Application $application, int $orderId): ?Model\Insales\Order;
    
        /**
         * Получение суммы оплаченных заказов клиента
         *
         * @param Model\Insales\Client $client
         * @return float
         */
        public function getPaymentOrderSumByClient(Model\Insales\Client $client): float;
    
        /**
         * Получение количества оплаченных заказов клиента
         *
         * @param Model\Insales\Client $client
         * @return int
         */
        public function getPaymentOrderCountByClient(Model\Insales\Client $client): int;
	
		/**
		 * Первый оплаченный заказ
		 *
		 * @param Model\Insales\Client $client
		 * @return Model\Insales\Order|null
		 */
		public function getFirstPaymentOrderClient(Model\Insales\Client $client): ?Model\Insales\Order;
	
		/**
		 * Последний оплаченный заказ
		 *
		 * @param Model\Insales\Client $client
		 * @return Model\Insales\Order|null
		 */
		public function getLastPaymentOrderClient(Model\Insales\Client $client): ?Model\Insales\Order;
    }