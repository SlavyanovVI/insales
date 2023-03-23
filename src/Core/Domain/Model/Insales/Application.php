<?php
    
    namespace App\Core\Domain\Model\Insales;
    
    use App\Core\Domain\Model\Traits;
    use Doctrine\ORM\Mapping as ORM;
    
    #[ORM\Entity]
    #[ORM\Table(name: 'application')]
    #[ORM\HasLifecycleCallbacks]
    class Application
    {
        
        use Traits\Id;
        use Traits\Dates;
        use Traits\Uuid;
        
        #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
        private int $insalesId;
        
        #[ORM\Column(type: 'string', length: 500)]
        private string $url;
        
        #[ORM\Column(type: 'string', length: 255)]
        private string $password;
        
        #[ORM\Column(type: 'string', length: 255)]
        private string $passwordToken;
        
        #[ORM\Embedded(class: Embed\Authentication::class, columnPrefix: 'auth_')]
        private Embed\Authentication $authentication;
    
        #[ORM\Embedded(class: Embed\Import::class, columnPrefix: 'import_')]
        private Embed\Import $import;
    
        #[ORM\Embedded(class: Embed\Options::class, columnPrefix: 'options_')]
        private Embed\Options $options;
        
        #[ORM\Column(type: 'datetime', nullable: true, options: ['default' => null])]
        private ?\DateTime $lastExportDate = null;
        
        #[ORM\Column(type: 'bigint', options: ['default' => 0, 'unsigned' => true])]
        private int $readyExportClient = 0;
		
		/**
		 * Количество отклоненных адресов
		 * @var bool
		 */
		#[ORM\Column(type: 'bigint', options: ['default' => 0])]
		private int $bouncedEmailCount = 0;
	
		/**
		 * Количество одноразовых email
		 * @var int
		 */
		#[ORM\Column(type: 'bigint', options: ['default' => 0])]
		private int $fakeEmailCount = 0;
		
		#[ORM\Column(type: 'boolean', options: ['default' => false])]
		private bool $installNotificationSend = false;
        
        public function __construct()
        {
            $this->authentication = new Embed\Authentication();
            $this->import = new Embed\Import();
            $this->options = new Embed\Options();
        }
    
        /**
         * @return int
         */
        public function getInsalesId(): int
        {
            return $this->insalesId;
        }
    
        /**
         * @param int $insalesId
         * @return Application
         */
        public function setInsalesId(int $insalesId): Application
        {
            $this->insalesId = $insalesId;
            return $this;
        }
    
        /**
         * @return string
         */
        public function getUrl(): string
        {
            return $this->url;
        }
    
        /**
         * @param string $url
         * @return Application
         */
        public function setUrl(string $url): Application
        {
            $this->url = $url;
            return $this;
        }
    
        /**
         * @return string
         */
        public function getPassword(): string
        {
            return $this->password;
        }
    
        /**
         * @param string $password
         * @return Application
         */
        public function setPassword(string $password): Application
        {
            $this->password = $password;
            return $this;
        }
    
        /**
         * @return string
         */
        public function getPasswordToken(): string
        {
            return $this->passwordToken;
        }
    
        /**
         * @param string $passwordToken
         * @return Application
         */
        public function setPasswordToken(string $passwordToken): Application
        {
            $this->passwordToken = $passwordToken;
            return $this;
        }
    
        /**
         * @return Embed\Authentication
         */
        public function getAuthentication(): Embed\Authentication
        {
            return $this->authentication;
        }
    
        /**
         * @param Embed\Authentication $authentication
         * @return Application
         */
        public function setAuthentication(Embed\Authentication $authentication): Application
        {
            $this->authentication = $authentication;
            return $this;
        }
    
        /**
         * @return Embed\Import
         */
        public function getImport(): Embed\Import
        {
            return $this->import;
        }
    
        /**
         * @param Embed\Import $import
         * @return Application
         */
        public function setImport(Embed\Import $import): Application
        {
            $this->import = $import;
            return $this;
        }
    
        /**
         * @return Embed\Options
         */
        public function getOptions(): Embed\Options
        {
            return $this->options;
        }
    
        /**
         * @param Embed\Options $options
         * @return Application
         */
        public function setOptions(Embed\Options $options): Application
        {
            $this->options = $options;
            return $this;
        }
    
        /**
         * @return \DateTime|null
         */
        public function getLastExportDate(): ?\DateTime
        {
            return $this->lastExportDate;
        }
    
        /**
         * @param \DateTime|null $lastExportDate
         * @return Application
         */
        public function setLastExportDate(?\DateTime $lastExportDate): Application
        {
            $this->lastExportDate = $lastExportDate;
            return $this;
        }
    
        /**
         * @return int
         */
        public function getReadyExportClient(): int
        {
            return $this->readyExportClient;
        }
    
        /**
         * @param int $readyExportClient
         * @return Application
         */
        public function setReadyExportClient(int $readyExportClient): Application
        {
            $this->readyExportClient = $readyExportClient;
            return $this;
        }
	
		/**
		 * @return bool
		 */
		public function isInstallNotificationSend(): bool
		{
			return $this->installNotificationSend;
		}
	
		/**
		 * @param bool $installNotificationSend
		 * @return Application
		 */
		public function setInstallNotificationSend(bool $installNotificationSend): Application
		{
			$this->installNotificationSend = $installNotificationSend;
			return $this;
		}
	
		/**
		 * @return int
		 */
		public function getBouncedEmailCount(): int
		{
			return $this->bouncedEmailCount;
		}
	
		/**
		 * @param int $bouncedEmailCount
		 * @return Application
		 */
		public function setBouncedEmailCount(int $bouncedEmailCount): Application
		{
			$this->bouncedEmailCount = $bouncedEmailCount;
			return $this;
		}
	
		/**
		 * @return int
		 */
		public function getFakeEmailCount(): int
		{
			return $this->fakeEmailCount;
		}
	
		/**
		 * @param int $fakeEmailCount
		 * @return Application
		 */
		public function setFakeEmailCount(int $fakeEmailCount): Application
		{
			$this->fakeEmailCount = $fakeEmailCount;
			return $this;
		}
    }