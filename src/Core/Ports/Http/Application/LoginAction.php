<?php
    
    namespace App\Core\Ports\Http\Application;
    
    use App\Core\Application\Command\Insales\Application\LoginApplication\LoginCommand;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use App\Core\Ports\Http\Error\SessionEndAction;
    use App\Shared\Infrastructure\Http\ParamFetcher;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Routing\RouterInterface;

    /**
     * Авторизация в приложении
     *
     * Class LoginAction
     * @package App\Core\Ports\Http\Application
     */
    final class LoginAction
    {
        
        public const ROUTE_NAME = 'application.login';
    
        /**
         * @param HandlerInterface $handler
         * @param RouterInterface $router
         */
        public function __construct(
            private readonly HandlerInterface $handler,
            private readonly RouterInterface $router
        )
        {
        }
    
        #[Route(
            path: '/application/login',
            name: self::ROUTE_NAME
        )]
        public function __invoke(Request $request): RedirectResponse
        {
    
            try
            {
        
                $paramFetcher = ParamFetcher::fromRequestQuery($request);
        
                $command = new LoginCommand();
        
                $command->setInsalesId($paramFetcher->getNullableInt('insales_id'))
                    ->setShop($paramFetcher->getNullableString('shop'))
                    ->setToken2($paramFetcher->getNullableString('token2'))
                    ->setToken3($paramFetcher->getNullableString('token3'))
                    ->setEmailConfirmed($paramFetcher->getNullableString('email_confirmed'))
                    ->setUserId($paramFetcher->getNullableInt('user_id'))
                    ->setUserEmail($paramFetcher->getNullableString('user_email'))
                    ->setUserName($paramFetcher->getNullableString('user_name'))
                ;
        
                return $this->handler->handle($command);
            }
            catch (\Exception)
            {
                return new RedirectResponse(
                    $this->router->generate(
                        SessionEndAction::ROUTE_NAME
                    )
                );
            }
        }
    }