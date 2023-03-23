<?php
    
    namespace App\Core\Domain\Infrastructure\Service;

    use App\Core\Domain\Model;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Contracts\HttpClient;
    use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
    use Symfony\Contracts\HttpClient\ResponseInterface;

    /**
     * Class DashMailClient
     * @package App\Core\Domain\Infrastructure\Service
     */
    final class DashMailClient implements Interfaces\DashMailClientInterface
	{
        
        private array $options = [];
        
        private const API_URL = 'https://api.dashamail.com/';
        public const API_METHOD_ACCOUNT_GET_BALANCE = 'account.get_balance';
        public const API_METHOD_LIST_ADD = 'lists.add';
		public const API_METHOD_LIST_ADD_MEMBER_BATCH = 'lists.add_member_batch';
		public const API_METHOD_LIST_UPDATE_MEMBER = 'lists.update_member';
		public const API_METHOD_LIST_GET_MEMBER = 'lists.get_members';
    
        /**
         * @param HttpClient\HttpClientInterface $httpClient
         */
        public function __construct(
            private readonly HttpClient\HttpClientInterface $httpClient
        )
        {
        }
    
        /**
         * @param Model\Insales\Application $application
         * @return void
         */
        public function initializeApplication(Model\Insales\Application $application): void
        {
            $this->options['api_login'] = $application->getAuthentication()->getLogin();
            $this->options['api_password'] = $application->getAuthentication()->getPassword();
        }
    
        /**
         * Отправка запроса
         *
         * @param string $action
         * @param array $params
         * @return ResponseInterface
         * @throws BusinessLogicViolationException
         * @throws TransportExceptionInterface
         */
        private function sendRequest(string $action, array $params = []): HttpClient\ResponseInterface
        {
			
            try
            {
				
				$url = self::API_URL
					. '?'
					. 'insales&'
					. \http_build_query(
						[
							'method' => $action
						]
					)
				;
				
				$request = [
					'verify_peer' => false,
					'body' => \array_merge(
						[
							'username' => $this->options['api_login'],
							'password' => $this->options['api_password'],
						],
						$params
					)
				];
				
                $response = $this->httpClient->request(
                    Request::METHOD_POST,
                    $url,
                    $request
                );
				
				return $response;
            }
            catch (\Throwable $throwable)
            {
                throw new BusinessLogicViolationException(
                    $throwable->getMessage(),
                    0,
                    $throwable
                );
            }
        }
    
        /**
         * @param string $login
         * @param string $password
         * @return bool
         * @throws BusinessLogicViolationException
         * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
         * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
         * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
         * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
         */
        public function checkAuthentication(string $login, string $password): bool
        {
			
            $response = $this->httpClient->request(
				Request::METHOD_POST,
				self::API_URL
				. '?'
				. 'insales&'
				. \http_build_query(
					[
						'method' => self::API_METHOD_ACCOUNT_GET_BALANCE,
						'username' => $login,
						'password' => $password
					]
				),
				[
					'verify_peer' => false,
				]
			);
			
            $fields = \json_decode($response->getContent(), true);

            if(
                !empty($fields['response']['msg']['type'])
                && $fields['response']['msg']['type'] === 'error'
                && !empty($fields['response']['msg']['err_code'])
            )
            {
                throw new BusinessLogicViolationException(
                    $fields['response']['msg']['text'] ?? BusinessLogicViolationException::API_ACCESS_ERROR
                );
            }
            
            return true;
        }
    
        /**
         * @param array $request
         * @return int
         * @throws BusinessLogicViolationException
         */
        public function createAddressBook(array $request): int
        {

            try
            {
                $response = $this->sendRequest(
                    self::API_METHOD_LIST_ADD,
                    $request
                );

                $fields = \json_decode($response->getContent(), true);
            }
            catch (\Throwable $throwable)
            {
                throw new BusinessLogicViolationException(
                    $throwable->getMessage()
                );
            }

            if(
                !empty($fields['response']['msg']['type'])
                && $fields['response']['msg']['type'] === 'error'
                && !empty($fields['response']['msg']['err_code'])
            )
            {
                throw new BusinessLogicViolationException(
                    $fields['response']['msg']['text'] ?? BusinessLogicViolationException::API_ACCESS_ERROR,
                        (int) $fields['response']['msg']['err_code'] ?? 0
                );
            }
            
            return (int) $fields['response']['data']['list_id'] ?? 0;
        }
	
		/**
		 * @param array $request
		 * @return void
		 * @throws BusinessLogicViolationException
		 */
		public function createClients(array $request): array
		{
			
			try
			{
				$response = $this->sendRequest(
					self::API_METHOD_LIST_ADD_MEMBER_BATCH,
					$request
				);
				
				$fields = \json_decode($response->getContent(), true);
				
				if(
					!empty($fields['response']['msg']['type'])
					&& $fields['response']['msg']['type'] === 'error'
					&& !empty($fields['response']['msg']['err_code'])
				)
				{
					throw new BusinessLogicViolationException(
						$fields['response']['msg']['text'] ?? BusinessLogicViolationException::API_ACCESS_ERROR,
						(int) $fields['response']['msg']['err_code'] ?? 0
					);
				}
				
				return $fields;
			}
			catch (\Throwable $throwable)
			{
				throw new BusinessLogicViolationException(
					$throwable->getMessage()
				);
			}
		}
	
		/**
		 * @param array $request
		 * @return array
		 * @throws BusinessLogicViolationException
		 */
		public function updateClient(array $request): array
		{
			try
			{
				$response = $this->sendRequest(
					self::API_METHOD_LIST_UPDATE_MEMBER,
					$request
				);
				
				$fields = \json_decode($response->getContent(), true);
				
				if(
					!empty($fields['response']['msg']['type'])
					&& $fields['response']['msg']['type'] === 'error'
					&& !empty($fields['response']['msg']['err_code'])
				)
				{
					throw new BusinessLogicViolationException(
						$fields['response']['msg']['text'] ?? BusinessLogicViolationException::API_ACCESS_ERROR,
						(int) $fields['response']['msg']['err_code'] ?? 0
					);
				}
				
				return $fields;
			}
			catch (\Throwable $throwable)
			{
				throw new BusinessLogicViolationException(
					$throwable->getMessage()
				);
			}
		}
	
		/**
		 * @param string $email
		 * @param int $listId
		 * @return array
		 * @throws BusinessLogicViolationException
		 */
		public function getClient(string $email, int $listId): array
		{
			try
			{
				$response = $this->sendRequest(
					self::API_METHOD_LIST_GET_MEMBER,
					[
						'email' => $email,
						'list_id' => $listId
					]
				);
				
				$fields = \json_decode($response->getContent(), true);
				
				if(
					!empty($fields['response']['msg']['type'])
					&& $fields['response']['msg']['type'] === 'error'
					&& !empty($fields['response']['msg']['err_code'])
				)
				{
					throw new BusinessLogicViolationException(
						$fields['response']['msg']['text'] ?? BusinessLogicViolationException::API_ACCESS_ERROR,
						(int) $fields['response']['msg']['err_code'] ?? 0
					);
				}
				
				return $fields;
			}
			catch (\Throwable $throwable)
			{
				throw new BusinessLogicViolationException(
					$throwable->getMessage()
				);
			}
		}
	}