<?php
    
    namespace App\Core\Application\Command\Insales\Import\ImportOrders;
    
    use App\Core\Domain\Model;

    /**
     * Импорт заказов
     *
     * Class ImportOrdersCommand
     * @package App\Core\Application\Command\Insales\Import\ImportOrders
     */
    final class ImportOrdersCommand
    {
    
        /**
         * @var Model\Insales\Application
         */
        private Model\Insales\Application $application;
    
        /**
         * @param Model\Insales\Application $shop
         */
        public function __construct(Model\Insales\Application $shop)
        {
            $this->application = $shop;
        }
    
        /**
         * @return Model\Insales\Application
         */
        public function getApplication(): Model\Insales\Application
        {
            return $this->application;
        }
    }