<?php
    
    namespace App\Shared\Domain\Exception;

    /**
     * Class AccessForbiddenException
     * @package App\Shared\Domain\Exception
     */
    class AccessForbiddenException extends InvalidInputDataException
    {
        public const TOKEN_VERIFY_FAIL = 'TOKEN_VERIFY_FAIL';
        public const SESSION_CHECK_FAIL = 'SESSION_CHECK_FAIL';
    }