<?php

    namespace App\Core\Domain\Infrastructure;

    use Symfony\Component\Messenger\Exception\HandlerFailedException;
    use Symfony\Component\Messenger\Exception\LogicException;
    use Symfony\Component\Messenger\Exception\RuntimeException;
    use Symfony\Component\Messenger\MessageBusInterface;
    use Symfony\Component\Messenger\Stamp\HandledStamp;

    /**
     * Class Handler
     * @package App\Core\Infrastructure
     */
    final class Handler implements HandlerInterface
    {

        /**
         * @param MessageBusInterface $messageBus
         */
        public function __construct(
            protected MessageBusInterface $messageBus,
        )
        {
        }

        /**
         * @param object $message
         *
         * @return mixed
         * @throws \Throwable
         * @see \Symfony\Component\Messenger\HandleTrait
         */
        public function handle(object $message): mixed
        {

            if (!$this->messageBus instanceof MessageBusInterface) {
                throw new LogicException(sprintf('You must provide a "%s" instance in the "%s::$messageBus" property, "%s" given.', MessageBusInterface::class, static::class, get_debug_type($this->messageBus)));
            }

            try
            {
                $envelope = $this->messageBus->dispatch($message);
            }
            catch (HandlerFailedException $handlerFailedException)
            {

                $current = \current($handlerFailedException->getNestedExceptions());

                if($current->getPrevious()?->getPrevious() instanceof \Exception)
                {
                    throw $current->getPrevious()->getPrevious();
                }

                if($current->getPrevious() instanceof \Exception)
                {
                    throw $current->getPrevious();
                }

                throw $current;
            }

            /** @var HandledStamp[] $handledStamps */
            $handledStamps = $envelope->all(HandledStamp::class);

            if (!$handledStamps) {
                throw new LogicException(sprintf('Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".', get_debug_type($envelope->getMessage()), static::class, __FUNCTION__));
            }

            if (\count($handledStamps) > 1) {
                $handlers = implode(', ', array_map(function (HandledStamp $stamp): string {
                    return sprintf('"%s"', $stamp->getHandlerName());
                }, $handledStamps));

                throw new LogicException(sprintf('Message of type "%s" was handled multiple times. Only one handler is expected when using "%s::%s()", got %d: %s.', get_debug_type($envelope->getMessage()), static::class, __FUNCTION__, \count($handledStamps), $handlers));
            }

            return $handledStamps[0]->getResult();
        }

        /**
         * @param object $message
         *
         * @return \Symfony\Component\Messenger\Envelope
         */
        public function dispatch(object $message): \Symfony\Component\Messenger\Envelope
        {
            return $this->messageBus->dispatch($message);
        }
    }
