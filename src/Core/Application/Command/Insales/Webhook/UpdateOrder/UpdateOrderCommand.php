<?php
    
    namespace App\Core\Application\Command\Insales\Webhook\UpdateOrder;
    
    use App\Core\Domain\Model;

    /**
     * Webhook обновления заказа
     *
     * Class UpdateOrderCommand
     * @package App\Core\Application\Command\Insales\Webhook\UpdateOrder
     */
    final class UpdateOrderCommand
    {
    
        /**
         * @var Model\Insales\Application
         */
        private Model\Insales\Application $application;
    
        /**
         * @var array
         */
        private array $fields;
    
        /**
         * @param Model\Insales\Application $application
         * @param array $fields
         */
        public function __construct(Model\Insales\Application $application, array $fields)
        {
            $this->application = $application;
            $this->fields = $fields;
        }
    
        /**
         * @return Model\Insales\Application
         */
        public function getApplication(): Model\Insales\Application
        {
            return $this->application;
        }
    
        /**
         * @return array
         */
        public function getFields(): array
        {
            return $this->fields;
        }
    }