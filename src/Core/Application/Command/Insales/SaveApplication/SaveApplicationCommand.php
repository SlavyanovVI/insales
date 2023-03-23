<?php
    
    namespace App\Core\Application\Command\Insales\SaveApplication;
    
    use App\Core\Domain\Model;

    /**
     * Class SaveApplicationCommand
     * @package App\Core\Application\Command\Insales\SaveApplication
     */
    final class SaveApplicationCommand
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