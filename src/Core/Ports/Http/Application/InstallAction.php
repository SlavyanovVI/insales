<?php
    
    namespace App\Core\Ports\Http\Application;
    
    use App\Core\Application\Command\Insales\Application\InstallApplication\InstallApplicationCommand;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use App\Shared\Infrastructure\Http\ParamFetcher;
    use Psr\Log\LoggerInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * Установка приложения
     *
     * Class InstallAction
     * @package App\Core\Ports\Http\Application
     */
    final class InstallAction
    {
        
        public const ROUTE_NAME = 'application.install';
    
        /**
         * @param HandlerInterface $handler
         * @param LoggerInterface $logger
         */
        public function __construct(
            private readonly HandlerInterface $handler,
            private readonly LoggerInterface $logger
        )
        {
        }
        
        #[Route(
            path: '/application/install',
            name: self::ROUTE_NAME
        )]
        public function __invoke(Request $request): Response
        {

            try
            {
                $paramFetcher = ParamFetcher::fromRequestQuery($request);
    
                $command = new InstallApplicationCommand(
                    $paramFetcher->getRequiredInt('insales_id'),
                    $paramFetcher->getRequiredString('shop'),
                    $paramFetcher->getRequiredString('token')
                );
    
                $this->handler->handle($command);
    
                return new Response(null, Response::HTTP_OK);
            }
            catch (BusinessLogicViolationException $businessLogicViolationException)
            {
                
                $this->logger->critical(
                    BusinessLogicViolationException::INSTALL_APPLICATION_FAIL,
                    [
                        $businessLogicViolationException->getMessage(),
                        $businessLogicViolationException->getFile(),
                        $businessLogicViolationException->getLine()
                    ]
                );
    
                return new Response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }