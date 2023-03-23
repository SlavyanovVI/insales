<?php
    
    namespace App\Core\Ports\Http\Webhook\Insales;

    use App\Core\Application\Command\Insales\UpdateReadyExportClientCount\UpdateReadyExportClientCountCommand;
    use App\Core\Domain\Model;
    use App\Core\Application\Command\Application\CalculationPayments\CalculationPaymentsCommand;
    use App\Core\Application\Command\Insales\Webhook\UpdateOrder\UpdateOrderCommand;
    use App\Core\Application\Query\Insales\GetApplication\GetApplicationQuery;
    use App\Core\Domain\Infrastructure\HandlerInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * Создание заказа insales
     *
     * Class CreateOrderAction
     * @package App\Core\Ports\Http\Webhook\Insales
     */
    final class CreateOrderAction
    {
        
        public const ROUTE_NAME = 'webhook.insales.create-order';
        
        public function __construct(
            private HandlerInterface $handler
        )
        {
        }
        
        #[Route(
            path: '/webhook/insales/{uuid}/create-order',
            name: self::ROUTE_NAME
        )]
        public function __invoke(string $uuid, Request $request): Response
        {
     
            /** @var Model\Insales\Application $application */
            $application = $this->handler->handle(
                new GetApplicationQuery(
                    $uuid
                )
            );
    
            /** @var Model\Insales\Order $order */
            $order = $this->handler->handle(
                new UpdateOrderCommand(
                    $application,
                    \json_decode($request->getContent(), true)
                )
            );
    
            $this->handler->handle(
                (new CalculationPaymentsCommand($application))
                    ->setClient($order->getClient())
            );
            
            $this->handler->handle(
                new UpdateReadyExportClientCountCommand(
                    $application
                )
            );
    
            return new Response(null, Response::HTTP_OK);
        }
    }