<?php

    namespace App\Core\Application\Command\Insales\Application\LoginApplication;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Core\Domain\Model;
    use App\Core\Ports\Http\Configuration\AuthenticationAction;
    use App\Shared\Domain\Exception\AccessForbiddenException;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use App\Shared\Domain\Exception\ResourceNotFoundException;
	use Psr\Log\LoggerInterface;
	use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
    use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\RequestStack;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;
    use Symfony\Component\Routing\RouterInterface;
	use Symfony\Contracts\HttpClient\HttpClientInterface;
	use Symfony\Contracts\Translation\TranslatorInterface;

	/**
     * Class LoginCommandHandler
     * @package App\Core\Application\Command\Application\LoginApplication
     */
    #[AsMessageHandler]
    final class LoginCommandHandler
    {
    
        /**
         * @var array
         */
        private array $options;
    
        /**
         * @var SessionInterface
         */
        private SessionInterface $session;
    
        /**
         * @param ApplicationRepositoryInterface $applicationRepository
         * @param RouterInterface $router
         * @param ParameterBagInterface $parameterBag
         * @param RequestStack $requestStack
         */
        public function __construct(
            private readonly ApplicationRepositoryInterface $applicationRepository,
            private readonly RouterInterface $router,
			private readonly HttpClientInterface $httpClient,
			private readonly TranslatorInterface $translator,
			private readonly LoggerInterface $logger,
            ParameterBagInterface $parameterBag,
            RequestStack $requestStack
        )
        {
            
            $this->session = $requestStack->getSession();
            
            $this->options = [
                'application_id' => $parameterBag->get('application.insales.application_id'),
				'email_send_url' => $parameterBag->get('application.dasha_mail.install_email.url'),
				'email_send_salt' => $parameterBag->get('application.dasha_mail.install_email.salt'),
            ];
        }

        /**
         * @throws ResourceNotFoundException
         * @throws BusinessLogicViolationException|AccessForbiddenException
         */
        public function __invoke(LoginCommand $command): RedirectResponse
        {

            if($command->getToken2() === null)
            {
                return $this->requestToken2($command);
            }

            if($this->session->has('insalesId'))
            {
                return $this->redirectConfiguration($command);
            }

            throw new BusinessLogicViolationException(
                BusinessLogicViolationException::APPLICATION_AUTHORIZE_FAIL
            );
        }

        /**
         * @throws ResourceNotFoundException
         */
        protected function requestToken2(LoginCommand $command): RedirectResponse
        {

            $application = $this->applicationRepository->findOneByInsalesId($command->getInsalesId());

            if($application === null)
            {
                throw new ResourceNotFoundException(
                    ResourceNotFoundException::SHOP_NOT_FOUND
                );
            }

            $application->setPasswordToken(\md5(\microtime().\md5(\microtime())));
            
            $this->applicationRepository->update($application);

            $this->session->remove('insalesId');
            $this->session->remove('insalesRequestToken');
            $this->session->remove('insalesUserToken');

            $this->session->set('insalesId', $application->getInsalesId());
            $this->session->set('insalesRequestToken', $application->getPasswordToken());

            return new RedirectResponse(
                'https://'
                . $application->getUrl()
                . '/admin/applications/'
                . $this->options['application_id']
                . '/login?token='
                . $application->getPasswordToken()
                . '&login='
                . $this->router->generate('application.login', [], $this->router::ABSOLUTE_URL)
            );
        }

        /**
         * @throws ResourceNotFoundException
         * @throws AccessForbiddenException
         */
        protected function redirectConfiguration(LoginCommand $command): RedirectResponse
        {

            $application = $this->applicationRepository->findOneByInsalesId(
                (int) $this->session->get('insalesId')
            );

            if($application === null)
            {
                throw new ResourceNotFoundException(
                    ResourceNotFoundException::SHOP_NOT_FOUND
                );
            }

            if(!$this->verifyToken($command, $application))
            {
                throw new AccessForbiddenException(
                    AccessForbiddenException::TOKEN_VERIFY_FAIL
                );
            }

            $this->session->set('insalesUserToken', $command->getToken2());

            $application->setPasswordToken($command->getToken2());
	
			if(
				!empty($command->getUserEmail())
				&& !$application->isInstallNotificationSend()
			)
			{
				$url = \strtr(
					$this->options['email_send_url'],
					[
						'%subject%' => $this->translator->trans('global.install_email.subject'),
						'%email%' => $command->getUserEmail(),
						'%salt%' => \md5($this->options['email_send_salt'] . $command->getUserEmail())
					]
				);
				
				try
				{
					
					$response = $this->httpClient->request(
						Request::METHOD_GET,
						$url
					);
					
					$application->setInstallNotificationSend(true);
				}
				catch (\Throwable $throwable)
				{
					
					$this->logger->critical(
						'Install email send',
						[
							'url' => $url,
							'error' => $throwable->getMessage()
						]
					);
				}
			}

            $this->applicationRepository->update($application);

            return new RedirectResponse(
                $this->router->generate(
                    AuthenticationAction::ROUTE_NAME,
                    [
                        'uuid' => $application->getUuid()
                    ]
                )
            );
        }

        /**
         * @param LoginCommand $command
         * @param \App\Core\Domain\Model\Insales\Application $shop
         * @return bool
         */
        protected function verifyToken(LoginCommand $command, Model\Insales\Application $shop): bool
        {
            return $command->getToken3() === \md5(
                \implode(
                    '',
                    [
                        $shop->getPasswordToken(),
                        $command->getUserEmail(),
                        $command->getUserName(),
                        $command->getUserId(),
                        $command->getEmailConfirmed(),
                        $shop->getPassword()
                    ]
                )
            );
        }
    }