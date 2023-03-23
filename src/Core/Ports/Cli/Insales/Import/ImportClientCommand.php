<?php
    
    namespace App\Core\Ports\Cli\Insales\Import;
    
    use App\Core\Application\Command\Insales\Import\ImportClients\ImportClientsCommand;
    use App\Core\Application\Query\Insales\GetNoFinishClientImport\GetNoFinishClientImportQuery;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    /**
     * Первичная загрузка клиентов из insales
     * При установки приложения
     *
     * Class ImportContactCommand
     * @package App\Core\Ports\Cli\Insales\Import
     */
    final class ImportClientCommand extends Command
    {
        public const NAME = 'application:insales:import:client';
    
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
            
            $application = $this->handler->handle(
                new GetNoFinishClientImportQuery()
            );
            
            if($application !== null)
            {
                $this->handler->handle(
                    new ImportClientsCommand(
                        $application
                    )
                );
            }
            
            return self::SUCCESS;
        }
    }