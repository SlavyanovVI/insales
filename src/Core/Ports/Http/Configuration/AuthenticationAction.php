<?php
    
    namespace App\Core\Ports\Http\Configuration;

    use App\Core\Application\Command\DashaMail\Authentication\AuthenticationCommand;
    use App\Core\Application\Command\Insales\SaveApplication\SaveApplicationCommand;
    use App\Core\Domain\Model;
    use App\Core\Domain\Infrastructure\Form;
    use App\Core\Application\Query\Insales\GetApplication\GetApplicationQuery;
    use App\Core\Domain\Infrastructure\Annotation\Access;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * Авторизация в приложении
     *
     * Class AuthenticationAction
     * @package App\Core\Ports\Http\Configuration
     */
    final class AuthenticationAction extends AbstractController
    {
        
        public const ROUTE_NAME = 'configuration.authentication';
    
        /**
         * @param HandlerInterface $handler
         */
        public function __construct(
            private readonly HandlerInterface $handler
        )
        {
        }
    
        #[Route(
            path: '/configuration/{uuid}/authentication',
            name: self::ROUTE_NAME
        )]
        #[Access(name: 'uuid')]
        public function __invoke(string $uuid, Request $request): Response
        {
            
            /** @var Model\Insales\Application $application */
            $application = $this->handler->handle(
                new GetApplicationQuery(
                    $uuid
                )
            );
    
            $form = $this->createForm(
                Form\Application\Authentication::class,
                $application->getAuthentication()
            );
            
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid())
            {

                $this->handler->handle(
                    new AuthenticationCommand(
                        $application,
                        $application->getAuthentication()->getLogin(),
                        $application->getAuthentication()->getPassword()
                    )
                );
                
                $this->handler->handle(
                    new SaveApplicationCommand(
                        $application
                    )
                );
    
                if($application->getAuthentication()->isAuthenticationSuccess())
                {
                    return $this->redirectToRoute(
                        OptionsAction::ROUTE_NAME,
                        [
                            'uuid' => $application->getUuid()
                        ]
                    );
                }
            }
    
            if($application->getAuthentication()->isAuthenticationSuccess())
            {
                $this->handler->handle(
                    new AuthenticationCommand(
                        $application,
                        $application->getAuthentication()->getLogin(),
                        $application->getAuthentication()->getPassword()
                    )
                );
    
                if(!$application->getAuthentication()->isAuthenticationSuccess())
                {
                    return $this->redirectToRoute(
                        self::ROUTE_NAME,
                        [
                            'uuid' => $application->getUuid()
                        ]
                    );
                }
                
                return $this->redirectToRoute(
                    OptionsAction::ROUTE_NAME,
                    [
                        'uuid' => $application->getUuid()
                    ]
                );
            }
            
            return $this->render(
                'configuration/authentication.html.twig',
                [
                    'application' => $application,
                    'form' => $form->createView(),
                ]
            );
        }
    }