<?php
    
    namespace App\Core\Application\Query\Insales\GetApplication;

    /**
     * Class GetApplicationQuery
     * @package App\Core\Application\Query\Insales\GetApplication
     */
    final class GetApplicationQuery
    {
    
        /**
         * @var string
         */
        private string $uuid;
    
        /**
         * @param string $uuid
         */
        public function __construct(string $uuid)
        {
            $this->uuid = $uuid;
        }
    
        /**
         * @return string
         */
        public function getUuid(): string
        {
            return $this->uuid;
        }
    }