<?php
	
	namespace App\Core\Application\Command\Insales\GenerateFailedEmailReport;

	use App\Core\Domain\Model;
	use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
	use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
	use Symfony\Component\Filesystem\Filesystem;
	use Symfony\Component\HttpFoundation\File\File;
	use Symfony\Component\Messenger\Attribute\AsMessageHandler;
	use Symfony\Contracts\Translation\TranslatorInterface;
	
	/**
	 * Class GenerateFailedEmailReportCommandHandler
	 * @package App\Core\Application\Command\Insales\GenerateFailedEmailReport
	 */
	#[AsMessageHandler]
	final class GenerateFailedEmailReportCommandHandler
	{
		
		/**
		 * @var array
		 */
		private array $options;
		
		/**
		 * @param ParameterBagInterface $parameterBag
		 * @param Filesystem $filesystem
		 * @param TranslatorInterface $translator
		 * @param ClientRepositoryInterface $clientRepository
		 */
		public function __construct(
			ParameterBagInterface $parameterBag,
			private readonly Filesystem $filesystem,
			private readonly TranslatorInterface $translator,
			private readonly ClientRepositoryInterface $clientRepository
		)
		{
			$this->options = [
				'path' => $parameterBag->get('application.path.fail_email_report')
			];
		}
		
		/**
		 * @param GenerateFailedEmailReportCommand $command
		 * @return File
		 */
		public function __invoke(GenerateFailedEmailReportCommand $command): File
		{
			
			$application = $command->getApplication();
			
			if(\is_dir($this->options['path']))
			{
				$this->filesystem->mkdir($this->options['path']);
			}
		
			$file = $this->filesystem->tempnam(
				$this->options['path'],
				$command->getApplication()->getUrl(),
				'.csv'
			);
			
			$csv = [];
			
			$messages = [
				'bounced_email' => $this->translator->trans('configuration.report.fail_email_report.bounced_email'),
				'fake_email' => $this->translator->trans('configuration.report.fail_email_report.fake_email'),
			];
			
			if($command->isClientWindows())
			{
				foreach($messages as $key => $message)
				{
					$messages[$key] = \mb_convert_encoding($message, 'Windows-1251');
				}
			}
			
			/** @var Model\Insales\Client[] $clients */
			$clients = $this->clientRepository->findBouncedEmailByApplication($application);
			
			foreach($clients as $client)
			{
				$csv[] = [
					$client->getEmail(),
					$messages['bounced_email']
				];
			}
			
			/** @var Model\Insales\Client[] $clients */
			$clients = $this->clientRepository->findFakeEmailByApplication($application);
			
			foreach($clients as $client)
			{
				$csv[] = [
					$client->getEmail(),
					$messages['fake_email']
				];
			}
			
			$handler = \fopen($file, 'w');
			
			foreach ($csv as $row)
			{
				\fputcsv($handler, $row,';');
			}
			
			\fclose($handler);
			
			return new File($file);
		}
	}