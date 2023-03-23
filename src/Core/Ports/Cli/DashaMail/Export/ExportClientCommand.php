<?php
    
    namespace App\Core\Ports\Cli\DashaMail\Export;

	use App\Core\Application\Command\DashaMail\ExportClients\ExportClientsCommand;
	use App\Core\Domain\Model;
    use App\Core\Application\Query\Insales\GetApplicationReadyToExport\GetApplicationReadyToExportQuery;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

    /**
     * Экспорт клиентов в dasha mail
	 * Каждую минут
     *
     * Class ExportClientCommand
     * @package App\Core\Ports\Cli\DashaMail\Export
     */
    final class ExportClientCommand extends Command
    {
    
        public const NAME = 'application:dasha-mail:export:client';
        
        private array $options;
        
        public function __construct(
            private readonly HandlerInterface $handler,
            ParameterBagInterface $parameterBag
        )
        {
            
            $this->options = [
                'export_client_limit' => $parameterBag->get('application.dasha_mail.export_client_limit')
            ];
            
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
                new GetApplicationReadyToExportQuery()
            );

            if($application === null)
            {
                return self::SUCCESS;
            }

            $this->handler->handle(
                (new ExportClientsCommand(
                    $application
                ))
                    ->setLimit($this->options['export_client_limit'])
            );
            
            return self::SUCCESS;
        }
    }