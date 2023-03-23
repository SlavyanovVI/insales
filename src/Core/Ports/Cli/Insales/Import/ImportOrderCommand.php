<?php
    
    namespace App\Core\Ports\Cli\Insales\Import;

    use App\Core\Application\Command\Application\CalculationPayments\CalculationPaymentsCommand;
    use App\Core\Application\Command\Insales\UpdateReadyExportClientCount\UpdateReadyExportClientCountCommand;
    use App\Core\Domain\Model;
    use App\Core\Application\Command\Insales\Import\ImportOrders\ImportOrdersCommand;
    use App\Core\Application\Query\Insales\GetNoFinishOrderImport\GetNoFinishOrderImportQuery;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    /**
     * Первичная загрузка заказов из insales
     * При установке приложения
     *
     * Class ImportOrderCommand
     * @package App\Core\Ports\Cli\Insales\Import
     */
    final class ImportOrderCommand extends Command
    {
        
        public const NAME = 'application:insales:import:order';
    
        /**
         * @param HandlerInterface $handler
         */
        public function __construct(
            private readonly HandlerInterface $handler
        )
        {
            parent::__construct(self::NAME);
        }
    
        /**
         * @param InputInterface $input
         * @param OutputInterface $output
         * @return int
         */
        protected function execute(InputInterface $input, OutputInterface $output): int
        {
            
            /** @var Model\Insales\Application|null $application */
            $application = $this->handler->handle(
                new GetNoFinishOrderImportQuery()
            );
            
            if($application !== null)
            {

                $this->handler->handle(
                    new ImportOrdersCommand(
                        $application
                    )
                );
                
                if($application->getImport()->isOrderImportFinish())
                {
                    
                    $this->handler->handle(
                        new CalculationPaymentsCommand(
                            $application
                        )
                    );
    
                    $this->handler->handle(
                        new UpdateReadyExportClientCountCommand(
                            $application
                        )
                    );
                }
            }
            
            return self::SUCCESS;
        }
    }