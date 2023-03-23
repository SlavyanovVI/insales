<?php
    
    namespace App\Shared\Domain\Exception;

    /**
     * Class ResourceNotFoundException
     * @package App\Shared\Domain\Exception
     */
    class ResourceNotFoundException extends InvalidInputDataException
    {
        public const SHOP_NOT_FOUND = 'SHOP_NOT_FOUND';
    }