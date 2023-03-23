<?php
    
    namespace App\Core\Application\Command\DashaMail\CreateAddressBook;
    
    use App\Core\Domain\Model;

    /**
     * Создание адресной книги
     *
     * Class CreateAddressBookCommand
     * @package App\Core\Application\Command\DashaMail\CreateAddressBook
     */
    final class CreateAddressBookCommand
    {
    
        /**
         * @var Model\Insales\Application
         */
        private Model\Insales\Application $application;
    
        /**
         * @var string
         */
        private string $title;
    
        /**
         * @param Model\Insales\Application $application
         * @param string $title
         */
        public function __construct(Model\Insales\Application $application, string $title)
        {
            $this->application = $application;
            $this->title = $title;
        }
    
        /**
         * @return Model\Insales\Application
         */
        public function getApplication(): Model\Insales\Application
        {
            return $this->application;
        }
    
        /**
         * @return string
         */
        public function getTitle(): string
        {
            return $this->title;
        }
    }