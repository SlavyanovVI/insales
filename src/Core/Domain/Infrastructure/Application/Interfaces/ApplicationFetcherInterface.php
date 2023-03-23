<?php

    namespace App\Core\Domain\Infrastructure\Application\Interfaces;

    use App\Core\Domain\Model;

    /**
     * Interface ShopFetcherInterface
     * @package App\Core\Infrastructure\Application
     */
    interface ApplicationFetcherInterface
    {

        /**
         * Получение текущего магазина
         * @return Model\Insales\Application
         */
        public function fetchApplication(): Model\Insales\Application;
    
        /**
         * Получение текущего магазина
         * @return Model\Insales\Application|null
         */
        public function fetchNullableApplication(): ?Model\Insales\Application;
    }