<?php
    
    namespace App\Core\Application\Command\DashaMail\Authentication;
    
    use App\Core\Domain\Model;
    use App\Core\Domain\Model\Insales\Application;

    /**
     * Авторизация
     *
     * Class AuthenticationCommand
     * @package App\Core\Application\Command\DashaMail\Authentication
     */
    final class AuthenticationCommand
    {
    
        /**
         * @var Model\Insales\Application
         */
        private Model\Insales\Application $application;
    
        /**
         * @var string
         */
        private string $login;
    
        /**
         * @var string
         */
        private string $password;
    
        /**
         * @param Application $application
         * @param string $login
         * @param string $password
         */
        public function __construct(Model\Insales\Application $application, string $login, string $password)
        {
            $this->application = $application;
            $this->login = $login;
            $this->password = $password;
        }
    
        /**
         * @return string
         */
        public function getLogin(): string
        {
            return $this->login;
        }
    
        /**
         * @return string
         */
        public function getPassword(): string
        {
            return $this->password;
        }
    
        /**
         * @return Application
         */
        public function getApplication(): Application
        {
            return $this->application;
        }
    }