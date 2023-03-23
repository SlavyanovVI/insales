<?php

    namespace App\Core\Domain\Infrastructure\Application;

    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Core\Domain\Model;
    use App\Shared\Domain\Exception\ResourceNotFoundException;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RequestStack;

    /**
     * Class ShopFetcher
     * @package App\Core\Infrastructure\Application
     */
    final class ApplicationFetcher implements Interfaces\ApplicationFetcherInterface
    {

        /** @var Request|null $request */
        protected ?Request $request = null;

        /**
         * @param RequestStack $requestStack
         * @param ApplicationRepositoryInterface $applicationRepository
         */
        public function __construct(
            RequestStack $requestStack,
            private readonly ApplicationRepositoryInterface $applicationRepository
        )
        {
            $this->request = $requestStack->getMainRequest();
        }

        /**
         * @return Model\Insales\Application
         * @throws ResourceNotFoundException
         */
        public function fetchApplication(): Model\Insales\Application
        {

            $uuid = null;

            if($this->request && $this->request->attributes->has('uuid'))
            {
                $uuid = $this->request->attributes->get('uuid');
            }

            if($uuid === null)
            {
                throw new ResourceNotFoundException(
                    ResourceNotFoundException::SHOP_NOT_FOUND
                );
            }

            $shop = $this->applicationRepository->findOneByUuid($uuid);

            if($shop === null)
            {
                throw new ResourceNotFoundException(
                    ResourceNotFoundException::SHOP_NOT_FOUND
                );
            }

            return $shop;
        }

        /**
         * @return Model\Insales\Application|null
         */
        public function fetchNullableApplication(): ?Model\Insales\Application
        {

            $uuid = null;

            if($this->request->attributes->has('uuid'))
            {
                $uuid = $this->request->attributes->get('uuid');
            }

            if($uuid === null)
            {
                return null;
            }

            return $this->applicationRepository->findOneByUuid($uuid);
        }
    }