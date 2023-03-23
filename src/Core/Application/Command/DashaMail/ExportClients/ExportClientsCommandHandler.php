<?php
	
	namespace App\Core\Application\Command\DashaMail\ExportClients;

	use App\Core\Application\Command\Insales\UpdateResultExportClient\UpdateResultExportClientCommand;
	use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
	use App\Core\Domain\Model;
	use App\Core\Application\Command\Insales\UpdateReadyExportClientCount\UpdateReadyExportClientCountCommand;
	use App\Core\Application\Query\Insales\GetClientReadyToExport\GetClientReadyToExportQuery;
	use App\Core\Domain\Infrastructure\HandlerInterface;
	use App\Core\Domain\Infrastructure\Service\Interfaces\DashMailClientInterface;
	use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
	use Symfony\Component\Messenger\Attribute\AsMessageHandler;
	
	/**
	 * Class ExportClientsCommandHandler
	 * @package App\Core\Application\Command\DashaMail\ExportClients
	 */
	#[AsMessageHandler]
	class ExportClientsCommandHandler
	{
		
		public const DASHA_MAIL_ID = Model\Insales\Client::DASHA_MAIL_ID;
		public const BOOK_VAR_CLIENT_EMAIL = Model\Insales\Client::CLIENT_EMAIL;
		public const BOOK_VAR_CLIENT_NAME = Model\Insales\Client::CLIENT_NAME;
		public const BOOK_VAR_CLIENT_LAST_NAME = Model\Insales\Client::CLIENT_LAST_NAME;
		public const BOOK_VAR_CLIENT_SECOND_NAME = Model\Insales\Client::CLIENT_SECOND_NAME;
		public const BOOK_VAR_CLIENT_PHONE = Model\Insales\Client::CLIENT_PHONE;
		public const BOOK_VAR_CLIENT_FIRST_ORDER_DATE = Model\Insales\Client::CLIENT_FIRST_ORDER_DATE;
		public const BOOK_VAR_CLIENT_LAST_ORDER_DATE = Model\Insales\Client::CLIENT_LAST_ORDER_DATE;
		public const BOOK_VAR_CLIENT_ORDER_COUNT = Model\Insales\Client::CLIENT_ORDER_COUNT;
		public const BOOK_VAR_CLIENT_ORDER_PAYMENT = Model\Insales\Client::CLIENT_ORDER_PAYMENT;
		public const BOOK_VAR_CLIENT_GROUP = Model\Insales\Client::CLIENT_GROUP;
		
		public const DATE_FORMAT = 'd.m.Y H:i';
		
		/**
		 * @var Model\Insales\Application|null
		 */
		private ?Model\Insales\Application $application;
		
		private array $options;
		
		/**
		 * @param DashMailClientInterface $client
		 * @param HandlerInterface $handler
		 * @param ClientRepositoryInterface $clientRepository
		 * @param ParameterBagInterface $parameterBag
		 */
		public function __construct(
			private readonly DashMailClientInterface $client,
			private readonly HandlerInterface $handler,
			private readonly ClientRepositoryInterface $clientRepository,
			ParameterBagInterface $parameterBag
		)
		{
			$this->options = [
				'limit' => (int) $parameterBag->get('application.dasha_mail.export_client_limit'),
				'replace_email_domain' => [
					'@ya.ru' => '@yandex.ru'
				],
				'replace_email_domain_flip' => [
					'@yandex.ru' => '@ya.ru'
				]
			];
		}
		
		/**
		 * @param ExportClientsCommand $command
		 * @return void
		 */
		public function __invoke(ExportClientsCommand $command): void
		{
			
			$this->application = $command->getApplication();
			$this->options['limit'] = $command->getLimit() ?? $this->options['limit'];
			
			$this->client->initializeApplication($this->application);
			
			/** @var Model\Insales\Client[] $clients */
			$clients = $this->handler->handle(
				new GetClientReadyToExportQuery(
					$this->application,
					$this->options['limit']
				)
			);
			
			$createClients = [];
			$updateClients = [];
			
			foreach($clients as $client)
			{
				if($client->getDashaMailId() === null)
				{
					$createClients[] = $client;
				}
				else
				{
					$updateClients[] = $client;
				}
			}

			if(!empty($createClients))
			{
				$this->createClients($createClients);
			}
			
			if(!empty($updateClients))
			{
				$this->updateClients($updateClients);
			}
			
			$this->handler->handle(
				new UpdateReadyExportClientCountCommand(
					$this->application
				)
			);

			$this->handler->handle(
				new UpdateResultExportClientCommand(
					$this->application
				)
			);
		}
		
		/**
		 * @param Model\Insales\Client[] $clients
		 * @return void
		 */
		private function createClients(array $clients): void
		{
			
			$request = [];
			
			foreach($clients as $client)
			{
				
				if($client->getDashaMailId() !== null)
				{
					continue;
				}
				
				$request[] = [
					self::BOOK_VAR_CLIENT_EMAIL => $client->getEmail(),
					self::BOOK_VAR_CLIENT_NAME => $client->getName(),
					self::BOOK_VAR_CLIENT_LAST_NAME => $client->getSurname(),
					self::BOOK_VAR_CLIENT_SECOND_NAME => $client->getMiddlename(),
					self::BOOK_VAR_CLIENT_PHONE => $client->getPhone(),
					self::BOOK_VAR_CLIENT_FIRST_ORDER_DATE => $client->getFirstOrderPaymentDate()?->format(self::DATE_FORMAT),
					self::BOOK_VAR_CLIENT_LAST_ORDER_DATE => $client->getLastOrderPaymentDate()?->format(self::DATE_FORMAT),
					self::BOOK_VAR_CLIENT_ORDER_COUNT => $client->getPaymentOrderCount(),
					self::BOOK_VAR_CLIENT_ORDER_PAYMENT => $client->getPaymentOrder(),
					self::BOOK_VAR_CLIENT_GROUP => $client->getClientGroup()?->getTitle()
				];
				
				$client->setExported(true);
				$this->clientRepository->update($client);
			}
			
			if(empty($request))
			{
				return;
			}
			
			$batch = \implode(
				';',
				\array_map(
					function($client)
					{
						return \implode(',', $client);
					},
					$request
				)
			);
			
			$response = $this->client->createClients(
				[
					'list_id' => $this->application->getOptions()->getAddressBookId(),
					'batch' => $batch
				]
			);
			
			$fixedEmails = [];

			if(!empty($response['response']['data']['fixed_emails']))
			{
				
				foreach($response['response']['data']['fixed_emails'] as $fixedEmail)
				{
					
					if(
						empty($fixedEmail['original'])
						|| empty($fixedEmail['fixed'])
					)
					{
						continue;
					}
					
					if($fixedEmail['fixed'] === 'bounced')
					{
						continue;
					}
					
					$fixedEmails[$fixedEmail['fixed']] = $fixedEmail['original'];
				}
			}
			
			if(!empty($response['response']['data']['members']))
			{
				
				foreach(
					\json_decode($response['response']['data']['members'], true)
					as $member
				)
				{
					
					$email = \strtr(
						$fixedEmails[$member['email']] ?? $member['email'],
						$this->options['replace_email_domain_flip']
					);
					
					$applicationClient = $this->clientRepository->findOneByApplicationAndClientEmail(
						$this->application,
						$email
					);
					
					if(!empty($applicationClient))
					{
						
						$applicationClient->setDashaMailId($member['id']);
						
						if($applicationClient->getEmail() !== $member['email'])
						{
							$applicationClient->setDashaMailEmail($member['email']);
						}
						
						$this->clientRepository->update($applicationClient);
					}
				}
			}
			
			if(!empty($response['response']['data']['bounced_emails']))
			{
				
				foreach(
					\explode(',', $response['response']['data']['bounced_emails'])
					as $email
				)
				{
					
					$applicationClient = $this->clientRepository->findOneByApplicationAndClientEmail(
						$this->application,
						$email
					);
					
					if(!empty($applicationClient))
					{
						$applicationClient->setDashaMailBouncedEmail(true);
						$this->clientRepository->update($applicationClient);
					}
				}
			}
			
			if(!empty($response['response']['data']['fake_emails']))
			{
				
				foreach(
					\explode(',', $response['response']['data']['fake_emails'])
					as $email
				)
				{
					
					$applicationClient = $this->clientRepository->findOneByApplicationAndClientEmail(
						$this->application,
						$email
					);
					
					if(!empty($applicationClient))
					{
						$applicationClient->setDashaMailFakeEmail(true);
						$this->clientRepository->update($applicationClient);
					}
				}
			}
		}
		
		/**
		 * @param Model\Insales\Client[] $clients
		 * @return void
		 */
		private function updateClients(array $clients): void
		{
			
			if(empty($clients))
			{
				return;
			}
			
			foreach($clients as $client)
			{
				$this->client->updateClient(
					[
						// 'member_id' => $client->getDashaMailId(),
						'email' => $client->getDashaMailEmail() ?? $client->getEmail(),
						'list_id' => $this->application->getOptions()->getAddressBookId(),
						'merge_1' => $client->getName(),
						'merge_2' => $client->getSurname(),
						'merge_3' => $client->getMiddlename(),
						'merge_4' => $client->getPhone(),
						'merge_5' => $client->getFirstOrderPaymentDate()?->format(self::DATE_FORMAT),
						'merge_6' => $client->getLastOrderPaymentDate()?->format(self::DATE_FORMAT),
						'merge_7' => $client->getPaymentOrderCount(),
						'merge_8' => $client->getPaymentOrder(),
						'merge_9' => $client->getClientGroup()?->getTitle() ?? ''
					]
				);
				
				$client->setExported(true);
				$this->clientRepository->update($client);
			}
		}
	}