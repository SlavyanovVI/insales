<?php
    
    namespace App\Core\Application\Command\Insales\Import\ImportClients;
    
    use App\Core\Domain\Model;

    /**
     * Импорт контактов
     *
     * Class ImportContactsCommand
     * @package App\Core\Application\Command\Insales\Import\ImportContacts
     */
    final class ImportClientsCommand
    {
    
        /**
         * @var Model\Insales\Application
         */
        private Model\Insales\Application $application;
    
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
    }