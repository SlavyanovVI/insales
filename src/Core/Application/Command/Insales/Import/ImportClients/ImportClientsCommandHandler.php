<?php
    
    namespace App\Core\Application\Command\Insales\Import\ImportClients;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientGroupRepositoryInterface;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ClientRepositoryInterface;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use InSales\API\ApiClient;
    use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;
    use App\Core\Domain\Model;

    #[AsMessageHandler]
    final class ImportClientsCommandHandler
    {
    
        /**
         * @var array
         */
        private array $options;
        
        /** @var int Лимит загрузки клиентов из insales на один запрос */
        private const LOAD_CLIENT_LIMIT = 400;
        
        public function __construct(
            ParameterBagInterface $parameterBag,
            private readonly ClientRepositoryInterface $clientRepository,
            private readonly ClientGroupRepositoryInterface $clientGroupRepository,
            private readonly ApplicationRepositoryInterface $applicationRepository
        )
        {
            $this->options = [
                'application_id' => $parameterBag->get('application.insales.application_id')
            ];
        }
    
        /**
         * @throws BusinessLogicViolationException
         */
        public function __invoke(ImportClientsCommand $command)
        {
            
            $application = $command->getApplication();
            
            $apiClient = new ApiClient(
                $this->options['application_id'],
                $application->getPassword(),
                $command->getApplication()->getUrl()
            );
            
            $clientGroups = $apiClient->getClientGroups();
            
            if(!$clientGroups->isSuccessful())
            {
                throw new BusinessLogicViolationException(
                    BusinessLogicViolationException::IMPORT_CLIENT_LOAD_CLIENT_GROUP_FAIL
                );
            }
    
            foreach($clientGroups->getData() as $insalesClientGroup)
            {
                $clientGroup = $this->clientGroupRepository->findOneByApplicationAndGroupId(
                    $application,
                    $insalesClientGroup['id']
                );
        
                if($clientGroup === null)
                {
            
                    $clientGroup = new Model\Insales\ClientGroup();
            
                    $clientGroup
                        ->setApplication($application)
                        ->setGroupId($insalesClientGroup['id'])
                    ;
                }
        
                $clientGroup->setTitle($insalesClientGroup['title']);
        
                $this->clientGroupRepository->update($clientGroup);
            }
            
            $filter = ['per_page' => self::LOAD_CLIENT_LIMIT];
            $response = $apiClient->getClients($filter);
    
            if(!$response->isSuccessful())
            {
                throw new BusinessLogicViolationException(
                BusinessLogicViolationException::IMPORT_CLIENT_LOAD_CLIENT_FAIL
                );
            }

            $insalesClients = [];
            
            for($page = 1; $page <= ($response->getHeaders()['x-total-pages'] ?? 1); $page++)
            {
    
                $filter = ['per_page' => self::LOAD_CLIENT_LIMIT, 'page' => $page];
                $response = $apiClient->getClients($filter);

                if($response->isSuccessful())
                {
                    $insalesClients = \array_merge(
                        $insalesClients,
                        $response->getData()
                    );
                }
            }
            
            foreach($insalesClients as $insalesClient)
            {

                if(empty($insalesClient['email']))
                {
                    continue;
                }

                $client = $this->clientRepository->findOneByApplicationAndClientEmail(
                    $application,
                    $insalesClient['email']
                );

                if($client === null)
                {

                    $client = new Model\Insales\Client();

                    $client
                        ->setApplication($application)
                        ->setEmail($insalesClient['email'])
                    ;
                }

                if(!empty($insalesClient['client_group_id']))
                {
                    $client->setClientGroup(
                        $this->clientGroupRepository->findOneByApplicationAndGroupId(
                            $application,
                            $insalesClient['client_group_id']
                        )
                    );
                }

                $client
                    ->setName($insalesClient['name'])
                    ->setMiddlename($insalesClient['middlename'])
                    ->setSurname($insalesClient['surname'])
                    ->setPhone($insalesClient['phone'])
                    ->setClientCreateAt(new \DateTime($insalesClient['created_at']))
                ;
				
				$insalesIds = $client->getClientInsalesIds();
				
				if(!\in_array($insalesClient['id'], $insalesIds))
				{
					$insalesIds[] = $insalesClient['id'];
					$client->setClientInsalesIds($insalesIds);
				}
	
				if(
					empty($insalesClient['client_group_id'])
					&& \count($client->getClientInsalesIds()) === 1
				)
				{
					$client->setClientGroup(null);
				}

                $this->clientRepository->add($client);
            }

            $application->getImport()->setClientImportFinish(true);
            
            $this->applicationRepository->update($application);
        }
    }