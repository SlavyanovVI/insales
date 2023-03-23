<?php
    
    namespace App\Core\Domain\Infrastructure\Annotation;

    #[\Attribute(\Attribute::TARGET_METHOD)]
    final class Access
    {
    
        /**
         * @var string|null
         */
        private ?string $name;
    
        /**
         * @var bool
         */
        private bool $autoRedirect = true;
    
        /**
         * @param string|null $name
         */
        public function __construct(
            ?string $name
        )
        {
            $this->name = $name;
        }
    
        /**
         * @return string|null
         */
        public function getName(): ?string
        {
            return $this->name;
        }
    
        /**
         * @return bool
         */
        public function isAutoRedirect(): bool
        {
            return $this->autoRedirect;
        }
    
        /**
         * @param bool $autoRedirect
         * @return Access
         */
        public function setAutoRedirect(bool $autoRedirect): Access
        {
            $this->autoRedirect = $autoRedirect;
            return $this;
        }
    }