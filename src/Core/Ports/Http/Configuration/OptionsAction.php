<?php
    
    namespace App\Core\Ports\Http\Configuration;

    use App\Core\Application\Query\Insales\GetCountClientReadyToExport\GetCountClientReadyToExportQuery;
    use App\Core\Domain\Infrastructure\Form;
    use App\Core\Domain\Model;
    use App\Core\Application\Query\Insales\GetApplication\GetApplicationQuery;
    use App\Core\Domain\Infrastructure\Annotation\Access;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * Настройка приложения
     *
     * Class OptionsAction
     * @package App\Core\Ports\Http\Configuration
     */
    final class OptionsAction extends AbstractController
    {
        public const ROUTE_NAME = 'configuration.options';
    
        /**
         * @param HandlerInterface $handler
         */
        public function __construct(
            private readonly HandlerInterface $handler
        )
        {
        }
        
        #[Route(
            path: '/configuration/{uuid}/options',
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
            
            return $this->render(
                'configuration/options.html.twig',
                [
                    'application' => $application,
                ]
            );
        }
    }