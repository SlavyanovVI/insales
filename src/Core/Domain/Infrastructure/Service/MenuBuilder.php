<?php

    namespace App\Core\Domain\Infrastructure\Service;

    use App\Core\Ports\Http;
    use App\Core\Domain\Infrastructure\Application\Interfaces\ApplicationFetcherInterface;
    use Knp\Menu\FactoryInterface;
    use Knp\Menu\ItemInterface;
    use Symfony\Component\HttpFoundation\RequestStack;
    use Symfony\Component\Routing\RouterInterface;
    use Symfony\Contracts\Translation\TranslatorInterface;

    /**
     * Class MenuBuilder
     * @package App\Core\Domain\Infrastructure\Service
     */
    final class MenuBuilder
    {
    
        /**
         * @var \Symfony\Component\HttpFoundation\Request|null
         */
        private ?\Symfony\Component\HttpFoundation\Request $request;
    
        public function __construct(
            private readonly FactoryInterface $factory,
            RequestStack $requestStack,
            private readonly ApplicationFetcherInterface $applicationFetcher
        )
        {
            $this->request = $requestStack->getMainRequest();
        }

        /**
         * @return ItemInterface
         */
        public function createMainMenu(): ItemInterface
        {

            $menu = $this->factory->createItem('root');
            $application = $this->applicationFetcher->fetchNullableApplication();

            if($application === null)
            {
                return $menu;
            }
            
            if($application->getAuthentication()->isAuthenticationSuccess())
            {
                $menu->addChild(
                    'configuration.menu.options',
                    [
                        'route' => Http\Configuration\OptionsAction::ROUTE_NAME,
                        'routeParameters' => [
                            'uuid' => $application->getUuid()
                        ]
                    ]
                );
            }
            else
            {
                $menu->addChild(
                    'configuration.menu.authentication',
                    [
                        'route' => Http\Configuration\AuthenticationAction::ROUTE_NAME,
                        'routeParameters' => [
                            'uuid' => $application->getUuid()
                        ]
                    ]
                );
            }
			
            $menu->addChild(
                'configuration.menu.help',
                [
                    'uri' => '#',
                ]
            );

            $menu->addChild(
                'configuration.menu.back_to_shop',
                [
                    'uri' => 'https://' . $application->getUrl(),
                ]
            );

            return $menu;
        }
    }