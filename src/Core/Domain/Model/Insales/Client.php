<?php
    
    namespace App\Core\Domain\Model\Insales;
    
    use App\Core\Domain\Model;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity]
    #[ORM\Table(name: 'clients')]
    #[ORM\HasLifecycleCallbacks]
    class Client
    {
    
    
        public const DASHA_MAIL_ID = 'DA_ID';
        public const CLIENT_EMAIL = 'C_EMAIL';
        public const CLIENT_NAME = 'C_NAME';
        public const CLIENT_LAST_NAME = 'C_L_NAME';
        public const CLIENT_SECOND_NAME = 'C_S_NAME';
        public const CLIENT_PHONE = 'C_PHONE';
        public const CLIENT_FIRST_ORDER_DATE = 'O_F_DATE';
        public const CLIENT_LAST_ORDER_DATE = 'O_L_DATE';
        public const CLIENT_ORDER_COUNT = 'O_COUNT';
        public const CLIENT_ORDER_PAYMENT = 'O_PAYMENT';
        public const CLIENT_GROUP = 'C_GROUP';
        
        use Model\Traits\Id;
        use Model\Traits\Dates;
        use Model\Traits\Uuid;
    
        #[ORM\ManyToOne(targetEntity: Model\Insales\Application::class)]
        #[ORM\JoinColumn(onDelete: 'CASCADE')]
        private Model\Insales\Application $application;
        
        #[ORM\ManyToOne(targetEntity: Model\Insales\ClientGroup::class)]
        #[ORM\JoinColumn(onDelete: 'SET NULL')]
        private ?Model\Insales\ClientGroup $clientGroup;
    
        #[ORM\Column(type: 'float', scale: 2, options: ['default' => 0, 'unsigned' => true])]
        private float $paymentOrder = 0;
        
        #[ORM\Column(type: 'bigint', options: ['unsigned' => true, 'default' => 0])]
        private int $paymentOrderCount = 0;
    
        #[ORM\Column(type: 'bigint', options: ['unsigned' => true, 'default' => 0])]
        private int $orderCount = 0;
        
        #[ORM\Column(type: 'boolean', options: ['default' => false])]
        private bool $exported = false;
    
        /**
         * Имя
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $name = null;
    
        /**
         * Фамилия
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $surname = null;
    
        /**
         * Отчество
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $middlename = null;
        
        /**
         * Email
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 255)]
        private string $email;
    
        /**
         * Номер телефона
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 70, nullable: true)]
        private ?string $phone = null;
    
        /**
         * Дата создания клиента в insales
         * @var \DateTime|null
         */
        #[ORM\Column(type: 'datetime', nullable: true, options: ['default' => null])]
        private ?\DateTime $clientCreateAt = null;
	
		/**
		 * Дата первой оплаты заказа
		 * @var \DateTime|null
		 */
		#[ORM\Column(type: 'datetime', nullable: true, options: ['default' => null])]
		private ?\DateTime $firstOrderPaymentDate = null;
		
		/**
		 * Дата последней оплаты заказа
		 * @var \DateTime|null
		 */
		#[ORM\Column(type: 'datetime', nullable: true, options: ['default' => null])]
		private ?\DateTime $lastOrderPaymentDate = null;
		
		#[ORM\Column(type: 'json')]
		private array $clientInsalesIds = [];
	
		/**
		 * Код синхронизации dasha-mail
		 * @var int|null
		 */
		#[ORM\Column(type: 'bigint', nullable: true, options: ['unsigned' => true])]
		private ?int $dashaMailId = null;
	
		/**
		 * Обновленный email от dasha-mail
		 * @var string|null
		 */
		#[ORM\Column(type: 'string', nullable: true)]
		private ?string $dashaMailEmail = null;
	
		/**
		 * Адрес отклонен dasha-mail
		 * @var bool
		 */
		#[ORM\Column(type: 'boolean', options: ['default' => false])]
		private bool $dashaMailBouncedEmail = false;
	
		/**
		 * Одноразовый email
		 * @var bool
		 */
		#[ORM\Column(type: 'boolean', options: ['default' => false])]
		private bool $dashaMailFakeEmail = false;
    
        /**
         * @return Application
         */
        public function getApplication(): Application
        {
            return $this->application;
        }
    
        /**
         * @param Application $application
         * @return Client
         */
        public function setApplication(Application $application): Client
        {
            $this->application = $application;
            return $this;
        }
    
        /**
         * @return ClientGroup|null
         */
        public function getClientGroup(): ?ClientGroup
        {
            return $this->clientGroup;
        }
    
        /**
         * @param ClientGroup|null $clientGroup
         * @return Client
         */
        public function setClientGroup(?ClientGroup $clientGroup): Client
        {
            $this->clientGroup = $clientGroup;
            return $this;
        }
    
        /**
         * @return string|null
         */
        public function getName(): ?string
        {
            return $this->name;
        }
    
        /**
         * @param string|null $name
         * @return Client
         */
        public function setName(?string $name): Client
        {
            $this->name = $name;
            return $this;
        }
    
        /**
         * @return string|null
         */
        public function getSurname(): ?string
        {
            return $this->surname;
        }
    
        /**
         * @param string|null $surname
         * @return Client
         */
        public function setSurname(?string $surname): Client
        {
            $this->surname = $surname;
            return $this;
        }
    
        /**
         * @return string|null
         */
        public function getMiddlename(): ?string
        {
            return $this->middlename;
        }
    
        /**
         * @param string|null $middlename
         * @return Client
         */
        public function setMiddlename(?string $middlename): Client
        {
            $this->middlename = $middlename;
            return $this;
        }
    
        /**
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email;
        }
    
        /**
         * @param string $email
         * @return Client
         */
        public function setEmail(string $email): Client
        {
            $this->email = $email;
            return $this;
        }
    
        /**
         * @return string|null
         */
        public function getPhone(): ?string
        {
            return $this->phone;
        }
    
        /**
         * @param string|null $phone
         * @return Client
         */
        public function setPhone(?string $phone): Client
        {
            $this->phone = $phone;
            return $this;
        }
    
        /**
         * @return \DateTime|null
         */
        public function getClientCreateAt(): ?\DateTime
        {
            return $this->clientCreateAt;
        }
    
        /**
         * @param \DateTime|null $clientCreateAt
         * @return Client
         */
        public function setClientCreateAt(?\DateTime $clientCreateAt): Client
        {
            $this->clientCreateAt = $clientCreateAt;
            return $this;
        }
    
        /**
         * @return float
         */
        public function getPaymentOrder(): float
        {
            return $this->paymentOrder;
        }
    
        /**
         * @param float $paymentOrder
         * @return Client
         */
        public function setPaymentOrder(float $paymentOrder): Client
        {
            $this->paymentOrder = $paymentOrder;
            return $this;
        }
    
        /**
         * @return bool
         */
        public function isExported(): bool
        {
            return $this->exported;
        }
    
        /**
         * @param bool $exported
         * @return Client
         */
        public function setExported(bool $exported): Client
        {
            $this->exported = $exported;
            return $this;
        }
    
        /**
         * @return int
         */
        public function getPaymentOrderCount(): int
        {
            return $this->paymentOrderCount;
        }
    
        /**
         * @param int $paymentOrderCount
         * @return Client
         */
        public function setPaymentOrderCount(int $paymentOrderCount): Client
        {
            $this->paymentOrderCount = $paymentOrderCount;
            return $this;
        }
    
        /**
         * @return int
         */
        public function getOrderCount(): int
        {
            return $this->orderCount;
        }
    
        /**
         * @param int $orderCount
         * @return Client
         */
        public function setOrderCount(int $orderCount): Client
        {
            $this->orderCount = $orderCount;
            return $this;
        }
	
		/**
		 * @return \DateTime|null
		 */
		public function getFirstOrderPaymentDate(): ?\DateTime
		{
			return $this->firstOrderPaymentDate;
		}
	
		/**
		 * @param \DateTime|null $firstOrderPaymentDate
		 * @return Client
		 */
		public function setFirstOrderPaymentDate(?\DateTime $firstOrderPaymentDate): Client
		{
			$this->firstOrderPaymentDate = $firstOrderPaymentDate;
			return $this;
		}
	
		/**
		 * @return \DateTime|null
		 */
		public function getLastOrderPaymentDate(): ?\DateTime
		{
			return $this->lastOrderPaymentDate;
		}
	
		/**
		 * @param \DateTime|null $lastOrderPaymentDate
		 * @return Client
		 */
		public function setLastOrderPaymentDate(?\DateTime $lastOrderPaymentDate): Client
		{
			$this->lastOrderPaymentDate = $lastOrderPaymentDate;
			return $this;
		}
	
		/**
		 * @return int|null
		 */
		public function getDashaMailId(): ?int
		{
			return $this->dashaMailId;
		}
	
		/**
		 * @param int|null $dashaMailId
		 * @return Client
		 */
		public function setDashaMailId(?int $dashaMailId): Client
		{
			$this->dashaMailId = $dashaMailId;
			return $this;
		}
	
		/**
		 * @return bool
		 */
		public function isDashaMailBouncedEmail(): bool
		{
			return $this->dashaMailBouncedEmail;
		}
	
		/**
		 * @param bool $dashaMailBouncedEmail
		 * @return Client
		 */
		public function setDashaMailBouncedEmail(bool $dashaMailBouncedEmail): Client
		{
			$this->dashaMailBouncedEmail = $dashaMailBouncedEmail;
			return $this;
		}
	
		/**
		 * @return bool
		 */
		public function isDashaMailFakeEmail(): bool
		{
			return $this->dashaMailFakeEmail;
		}
	
		/**
		 * @param bool $dashaMailFakeEmail
		 * @return Client
		 */
		public function setDashaMailFakeEmail(bool $dashaMailFakeEmail): Client
		{
			$this->dashaMailFakeEmail = $dashaMailFakeEmail;
			return $this;
		}
	
		/**
		 * @return array
		 */
		public function getClientInsalesIds(): array
		{
			return $this->clientInsalesIds;
		}
	
		/**
		 * @param array $clientInsalesIds
		 * @return Client
		 */
		public function setClientInsalesIds(array $clientInsalesIds): Client
		{
			$this->clientInsalesIds = $clientInsalesIds;
			return $this;
		}
	
		/**
		 * @return string|null
		 */
		public function getDashaMailEmail(): ?string
		{
			return $this->dashaMailEmail;
		}
	
		/**
		 * @param string|null $dashaMailEmail
		 * @return Client
		 */
		public function setDashaMailEmail(?string $dashaMailEmail): Client
		{
			$this->dashaMailEmail = $dashaMailEmail;
			return $this;
		}
    }