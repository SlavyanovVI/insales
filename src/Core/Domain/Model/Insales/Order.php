<?php
    
    namespace App\Core\Domain\Model\Insales;
    
    use App\Core\Domain\Model;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity]
    #[ORM\Table(name: 'orders')]
    #[ORM\HasLifecycleCallbacks]
    class Order
    {

        public const ORDER_PAYMENT_PAYED = 'paid';
        
        use Model\Traits\Id;
        use Model\Traits\Dates;
        use Model\Traits\Uuid;
        
        #[ORM\ManyToOne(targetEntity: Model\Insales\Application::class)]
        #[ORM\JoinColumn(onDelete: 'CASCADE')]
        private Model\Insales\Application $application;
        
        #[ORM\ManyToOne(targetEntity: Model\Insales\Client::class, cascade: ['persist'])]
        #[ORM\JoinColumn(onDelete: 'CASCADE')]
        private ?Model\Insales\Client $client = null;
        
        #[ORM\Column(type: 'boolean', options: ['default' => true])]
        private bool $payed = false;
        
        #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
        private int $orderId;
        
        #[ORM\Column(type: 'string', length: 255)]
        private string $orderNumber;
    
        #[ORM\Column(type: 'float', scale: 2, options: ['default' => 0, 'unsigned' => true])]
        private float $orderPrice = 0;
    
        #[ORM\Column(type: 'float', scale: 2, options: ['default' => 0, 'unsigned' => true])]
        private float $deliveryPrice = 0;
        
        #[ORM\Column(type: 'datetime')]
        private \DateTime $createOrderAt;
    
        /**
         * @return Application
         */
        public function getApplication(): Application
        {
            return $this->application;
        }
    
        /**
         * @param Application $application
         * @return Order
         */
        public function setApplication(Application $application): Order
        {
            $this->application = $application;
            return $this;
        }
    
        /**
         * @return bool
         */
        public function isPayed(): bool
        {
            return $this->payed;
        }
    
        /**
         * @param bool $payed
         * @return Order
         */
        public function setPayed(bool $payed): Order
        {
            $this->payed = $payed;
            return $this;
        }
    
        /**
         * @return int
         */
        public function getOrderId(): int
        {
            return $this->orderId;
        }
    
        /**
         * @param int $orderId
         * @return Order
         */
        public function setOrderId(int $orderId): Order
        {
            $this->orderId = $orderId;
            return $this;
        }
    
        /**
         * @return \DateTime
         */
        public function getCreateOrderAt(): \DateTime
        {
            return $this->createOrderAt;
        }
    
        /**
         * @param \DateTime $createOrderAt
         * @return Order
         */
        public function setCreateOrderAt(\DateTime $createOrderAt): Order
        {
            $this->createOrderAt = $createOrderAt;
            return $this;
        }
    
        /**
         * @return string
         */
        public function getOrderNumber(): string
        {
            return $this->orderNumber;
        }
    
        /**
         * @param string $orderNumber
         * @return Order
         */
        public function setOrderNumber(string $orderNumber): Order
        {
            $this->orderNumber = $orderNumber;
            return $this;
        }
    
        /**
         * @return float
         */
        public function getOrderPrice(): float
        {
            return $this->orderPrice;
        }
    
        /**
         * @param float $orderPrice
         * @return Order
         */
        public function setOrderPrice(float $orderPrice): Order
        {
            $this->orderPrice = $orderPrice;
            return $this;
        }
    
        /**
         * @return float
         */
        public function getDeliveryPrice(): float
        {
            return $this->deliveryPrice;
        }
    
        /**
         * @param float $deliveryPrice
         * @return Order
         */
        public function setDeliveryPrice(float $deliveryPrice): Order
        {
            $this->deliveryPrice = $deliveryPrice;
            return $this;
        }
    
        /**
         * @return Client|null
         */
        public function getClient(): ?Client
        {
            return $this->client;
        }
    
        /**
         * @param null|Client $client
         * @return Order
         */
        public function setClient(?Client $client): Order
        {
            $this->client = $client;
            return $this;
        }
    }