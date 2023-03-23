<?php

    namespace App\Shared\Domain\Exception;

    /**
     * Class BusinessLogicViolationException
     * @package App\Shared\Domain\Exception
     */
    class BusinessLogicViolationException extends InvalidInputDataException
    {
        
        public const INSTALL_APPLICATION_SHOP_EXISTS = 'INSTALL_APPLICATION_SHOP_EXISTS';
        
        public const INSTALL_APPLICATION_FAIL = 'INSTALL_APPLICATION_FAIL';
        public const INSTALL_APPLICATION_WEBHOOK_FAIL = 'INSTALL_APPLICATION_WEBHOOK_FAIL';
        public const REMOVE_APPLICATION_WEBHOOK_FAIL = 'REMOVE_APPLICATION_WEBHOOK_FAIL';
        
        public const APPLICATION_AUTHORIZE_FAIL = 'APPLICATION_AUTHORIZE_FAIL';
        
        public const IMPORT_CLIENT_LOAD_CLIENT_GROUP_FAIL = 'IMPORT_CLIENT_LOAD_CLIENT_GROUP_FAIL';
        
        public const UPDATE_ORDER_LOAD_CLIENT_FAIL = 'UPDATE_ORDER_LOAD_CLIENT_FAIL';
        
        public const UPDATE_ORDER_LOAD_CLIENT_GROUP_FAIL = 'UPDATE_ORDER_LOAD_CLIENT_GROUP_FAIL';
        
        public const IMPORT_CLIENT_LOAD_CLIENT_FAIL = 'IMPORT_CLIENT_LOAD_CLIENT_FAIL';
        
        public const IMPORT_ORDER_LOAD_FAIL = 'IMPORT_ORDER_LOAD_FAIL';
        
        public const API_ACCESS_ERROR = 'API_ACCESS_ERROR';
    }
