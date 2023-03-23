<?php
    
    namespace App\Core\Ports\Http\Application;

    use App\Core\Application\Command\Insales\Application\RemoveApplication\RemoveApplicationCommand;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * Удаление приложения
     *
     * Class RemoveAction
     * @package App\Core\Ports\Http\Application
     */
    final class RemoveAction
    {
        
        public const ROUTE_NAME = 'application.remove';
    
        /**
         * @param HandlerInterface $handler
         */
        public function __construct(
            private readonly HandlerInterface $handler
        )
        {
        }
    
        #[Route(
            path: '/application/remove',
            name: self::ROUTE_NAME
        )]
        public function __invoke(Request $request): Response
        {
    
            try
            {
                
                $this->handler->handle(
                    new RemoveApplicationCommand(
                        $request->query->getInt('insales_id')
                    )
                );
    
                return new Response(null, Response::HTTP_OK);
            }
            catch (\Exception)
            {
                return new Response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }