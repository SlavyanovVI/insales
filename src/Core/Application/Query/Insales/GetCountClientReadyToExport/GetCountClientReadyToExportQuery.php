<?php
    
    namespace App\Core\Application\Query\Insales\GetCountClientReadyToExport;
    
    use App\Core\Domain\Model;
    use PhpParser\Node\Expr\AssignOp\Mod;

    /**
     * Получение количества готовых к выгрузке клиентов insales
     *
     * Class GetCountClientReadyToExportQuery
     * @package App\Core\Application\Query\Insales\GetCountClientReadyToExport
     */
    final class GetCountClientReadyToExportQuery
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