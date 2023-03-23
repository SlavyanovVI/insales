<?php
    
    namespace App\Core\Domain\Model\Insales;
    
    use App\Core\Domain\Model;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity]
    #[ORM\Table(name: 'client_groups')]
    #[ORM\HasLifecycleCallbacks]
    class ClientGroup
    {
        
        use Model\Traits\Id;
        use Model\Traits\Dates;
        use Model\Traits\Uuid;
    
        #[ORM\ManyToOne(targetEntity: Model\Insales\Application::class)]
        #[ORM\JoinColumn(onDelete: 'CASCADE')]
        private Model\Insales\Application $application;
        
        #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
        private int $groupId;
    
        #[ORM\Column(type: 'string', length: 500)]
        private string $title;
    
        /**
         * @return Application
         */
        public function getApplication(): Application
        {
            return $this->application;
        }
    
        /**
         * @param Application $application
         * @return ClientGroup
         */
        public function setApplication(Application $application): ClientGroup
        {
            $this->application = $application;
            return $this;
        }
    
        /**
         * @return int
         */
        public function getGroupId(): int
        {
            return $this->groupId;
        }
    
        /**
         * @param int $groupId
         * @return ClientGroup
         */
        public function setGroupId(int $groupId): ClientGroup
        {
            $this->groupId = $groupId;
            return $this;
        }
    
        /**
         * @return string
         */
        public function getTitle(): string
        {
            return $this->title;
        }
    
        /**
         * @param string $title
         * @return ClientGroup
         */
        public function setTitle(string $title): ClientGroup
        {
            $this->title = $title;
            return $this;
        }
    }