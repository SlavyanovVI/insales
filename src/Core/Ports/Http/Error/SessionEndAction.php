<?php
    
    namespace App\Core\Ports\Http\Error;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * Class SessionEndAction
     * @package App\Core\Ports\Http\Error
     */
    final class SessionEndAction extends AbstractController
    {
        
        public const ROUTE_NAME = 'error.session-end';
     
        #[Route(
            path: '/error/session-end',
            name: self::ROUTE_NAME
        )]
        public function __invoke(): Response
        {
            return $this->render(
                'error/session-end.html.twig'
            );
        }
    }