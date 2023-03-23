<?php
    
    namespace App\Core\Application\Command\Application\CalculationPayments;
    
    use App\Core\Domain\Model;

    /**
     * Пересчет сум оплат клиентов по приложению
     *
     * Class CalculationPaymentsCommand
     * @package App\Core\Application\Command\Application\CalculationPayments
     */
    final class CalculationPaymentsCommand
    {
    
        /**
         * @var Model\Insales\Application
         */
        private Model\Insales\Application $application;
    
        /**
         * @var Model\Insales\Client
         */
        private ?Model\Insales\Client $client = null;
    
        /**
         * @param Model\Insales\Application $application
         */
        public function __construct(Model\Insales\Application $application)
        {
            $this->application = $application;
        }
    
        /**
         * @return Model\Insales\Application
         */
        public function getApplication(): Model\Insales\Application
        {
            return $this->application;
        }
    
        /**
         * @return Model\Insales\Client
         */
        public function getClient(): ?Model\Insales\Client
        {
            return $this->client;
        }
    
        /**
         * @param Model\Insales\Client $client
         * @return CalculationPaymentsCommand
         */
        public function setClient(?Model\Insales\Client $client): CalculationPaymentsCommand
        {
            $this->client = $client;
            return $this;
        }
    }