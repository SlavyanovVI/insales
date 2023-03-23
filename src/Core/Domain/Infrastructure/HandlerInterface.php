<?php

    namespace App\Core\Domain\Infrastructure;

    /**
     * Interface HandlerInterface
     * @package App\Core\Infrastructure
     */
    interface HandlerInterface
    {

        /**
         * Обработка, которая возвращает результат команды
         *
         * @see \Symfony\Component\Messenger\HandleTrait
         * @param object $message
         *
         * @return mixed
         */
        public function handle(object $message): mixed;

        /**
         * Обработка, которая не возвращает результат команды
         * должны использоваться если необходимо отправить команду на консюмер
         *
         * @see \Symfony\Component\Messenger\HandleTrait
         * @param object $message
         *
         * @return \Symfony\Component\Messenger\Envelope
         */
        public function dispatch(object $message): \Symfony\Component\Messenger\Envelope;
    }
