<?php
    
    namespace App\Core\Domain\Infrastructure\Annotation;
    
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Core\Ports\Http\Error\SessionEndAction;
    use App\Shared\Domain\Exception\AccessForbiddenException;
    use App\Shared\Domain\Exception\InvalidInputDataException;
    use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpKernel\Event\ControllerEvent;
    use Symfony\Component\HttpKernel\KernelEvents;
    use Symfony\Component\Routing\RouterInterface;

    /**
     * Class AccessEventSubscriber
     * @package App\Core\Domain\Infrastructure\Annotation
     */
    final class AccessEventSubscriber
    {
    
        /**
         * @param ApplicationRepositoryInterface $applicationRepository
         * @param RouterInterface $router
         */
        public function __construct(
            private readonly ApplicationRepositoryInterface $applicationRepository,
            private readonly RouterInterface                $router
        )
        {
        }
    
        /**
         * @throws AccessForbiddenException
         * @throws InvalidInputDataException
         */
        #[AsEventListener(KernelEvents::CONTROLLER)]
        public function onController(ControllerEvent $event)
        {

            if(
                !empty($event->getAttributes()[Access::class][0])
                && $event->getAttributes()[Access::class][0] instanceof Access
            )
            {
    
                /** @var Access $access */
                $access = $event->getAttributes()[Access::class][0];
    
                try
                {

                    if(!$event->getRequest()->getSession()->has('insalesId'))
                    {
                        throw new AccessForbiddenException(
                            AccessForbiddenException::SESSION_CHECK_FAIL
                        );
                    }

                    if(!$event->getRequest()->attributes->has($access->getName()))
                    {
                        throw new AccessForbiddenException(
                            AccessForbiddenException::SESSION_CHECK_FAIL
                        );
                    }
    
                    $application = $this->applicationRepository->findOneByUuid(
                        $event->getRequest()->attributes->get(
                            $access->getName()
                        )
                    );
    
                    if(
                        $application === null
                        || $application->getInsalesId() !== $event->getRequest()->getSession()->get('insalesId')
                    )
                    {
                        throw new AccessForbiddenException(
                            AccessForbiddenException::SESSION_CHECK_FAIL
                        );
                    }
    
                    if(empty($access->getName()))
                    {
                        throw new AccessForbiddenException(
                            InvalidInputDataException::INVALID_ACCESS_CONFIGURATION
                        );
                    }
                }
                catch (AccessForbiddenException $exception)
                {
                    if($access->isAutoRedirect())
                    {
                        $event->setController(
                            function()
                            {
                                return new RedirectResponse(
                                    $this->router->generate(
                                        SessionEndAction::ROUTE_NAME
                                    )
                                );
                            }
                        );
                    }
                    else
                    {
                        throw $exception;
                    }
                }
            }
        }
    }