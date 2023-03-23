<?php
    
    namespace App\Core\Application\Command\Insales\UpdateReadyExportClientCount;
    
    use App\Core\Domain\Model;

    /**
     * Обновление количества готовых к выгрузке клиентов
     *
     * Class UpdateReadyExportClientCountCommand
     * @package App\Core\Application\Command\Insales\UpdateReadyExportClientCount
     */
    final class UpdateReadyExportClientCountCommand
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