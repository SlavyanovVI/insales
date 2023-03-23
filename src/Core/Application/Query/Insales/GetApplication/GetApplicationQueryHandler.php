<?php
    
    namespace App\Core\Application\Query\Insales\GetApplication;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Shared\Domain\Exception\ResourceNotFoundException;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;

    /**
     * Class GetApplicationQueryHandler
     * @package App\Core\Application\Query\Insales\GetApplication
     */
    #[AsMessageHandler]
    final class GetApplicationQueryHandler
    {
    
        /**
         * @param ApplicationRepositoryInterface $shopRepository
         */
        public function __construct(
            private readonly ApplicationRepositoryInterface $shopRepository
        )
        {
        }
    
        /**
         * @param GetApplicationQuery $query
         * @return \App\Core\Domain\Model\Insales\Application
         * @throws ResourceNotFoundException
         */
        public function __invoke(GetApplicationQuery $query)
        {
            $shop = $this->shopRepository->findOneByUuid(
                $query->getUuid()
            );
            
            if($shop === null)
            {
                throw new ResourceNotFoundException(
                    ResourceNotFoundException::SHOP_NOT_FOUND
                );
            }
            
            return $shop;
        }
    }