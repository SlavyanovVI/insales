<?php
    
    namespace App\Core\Ports\Http\Configuration\Action;
    
    use App\Core\Domain\Model;
    use App\Core\Application\Command\DashaMail\CreateAddressBook\CreateAddressBookCommand;
    use App\Core\Application\Query\Insales\GetApplication\GetApplicationQuery;
    use App\Core\Domain\Infrastructure\Annotation\Access;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use App\Shared\Infrastructure\Http\ParamFetcher;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Contracts\Translation\TranslatorInterface;

    /**
     * Создание адресной книги
     *
     * Class CreateAddressBookAction
     * @package App\Core\Ports\Http\Configuration\Action
     */
    final class CreateAddressBookAction
    {
        public const ROUTE_NAME = 'configuration.action.create-address-book';
    
        /**
         * @param HandlerInterface $handler
         */
        public function __construct(
            private readonly HandlerInterface $handler
        )
        {
        }
    
        #[Route(
            path: '/configuration/{uuid}/action/create-address-book',
            name: self::ROUTE_NAME,
            methods: [Request::METHOD_POST]
        )]
        #[Access(name: 'uuid')]
        public function __invoke(string $uuid, Request $request): JsonResponse
        {
    
            /** @var Model\Insales\Application $application */
            $application = $this->handler->handle(
                new GetApplicationQuery(
                    $uuid
                )
            );
            
            $paramFetcher = ParamFetcher::fromRequestBody($request);
            
            try
            {
                
                $this->handler->handle(
                    new CreateAddressBookCommand(
                        $application,
                        $paramFetcher->getRequiredString('title')
                    )
                );
                
                return new JsonResponse(
                    [
                        'type' => 'success'
                    ]
                );
            }
            catch (\Throwable $throwable)
            {
                return match ($throwable::class)
                {
                    BusinessLogicViolationException::class => new JsonResponse(
                        [
                            'type' => 'error',
                            'message' => $throwable->getMessage()
                        ]
                    ),
                    default => new JsonResponse(
                        [
                            'type' => 'error',
                            'message' => $throwable->getMessage()
                        ]
                    ),
                };
            }
        }
    }