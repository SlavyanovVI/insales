<?php
    
    namespace App\Core\Application\Command\DashaMail\Authentication;

    use App\Core\Domain\Infrastructure\Service\Interfaces\DashMailClientInterface;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    /**
     * Class AuthenticationCommandHandler
     * @package App\Core\Application\Command\DashaMail\Authentication
     */
    #[AsMessageHandler]
    final class AuthenticationCommandHandler
    {
    
        /**
         * @param DashMailClientInterface $client
         */
        public function __construct(
            private readonly DashMailClientInterface $client
        )
        {
        }
    
        /**
         * @param AuthenticationCommand $command
         * @return bool
         */
        public function __invoke(AuthenticationCommand $command): bool
        {
            
            $application = $command->getApplication();
            
            try
            {
                
                $this->client->checkAuthentication(
                    $command->getLogin(),
                    $command->getPassword()
                );
                
                $application->getAuthentication()
                    ->setAuthenticationSuccess(true)
                    ->setAuthenticationError(null)
                ;
                
                return true;
            }
            catch (\Throwable $throwable)
            {
    
                $application->getAuthentication()
                    ->setAuthenticationSuccess(false)
                    ->setAuthenticationError($throwable->getMessage())
                ;
                
                return false;
            }
        }
    }