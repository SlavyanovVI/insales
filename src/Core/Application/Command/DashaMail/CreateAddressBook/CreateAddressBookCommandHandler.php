<?php
    
    namespace App\Core\Application\Command\DashaMail\CreateAddressBook;

    use App\Core\Domain\Model;
    use App\Core\Domain\Infrastructure\Repository\Insales\Interface\ApplicationRepositoryInterface;
    use App\Core\Domain\Infrastructure\Service\Interfaces\DashMailClientInterface;
    use App\Shared\Domain\Exception\BusinessLogicViolationException;
    use Symfony\Component\Messenger\Attribute\AsMessageHandler;
    use Symfony\Contracts\Translation\TranslatorInterface;

    #[AsMessageHandler]
    final class CreateAddressBookCommandHandler
    {
        
        public const BOOK_VAR_CLIENT_NAME = Model\Insales\Client::CLIENT_NAME;
        public const BOOK_VAR_CLIENT_LAST_NAME = Model\Insales\Client::CLIENT_LAST_NAME;
        public const BOOK_VAR_CLIENT_SECOND_NAME = Model\Insales\Client::CLIENT_SECOND_NAME;
        public const BOOK_VAR_CLIENT_PHONE = Model\Insales\Client::CLIENT_PHONE;
        public const BOOK_VAR_CLIENT_FIRST_ORDER_DATE = Model\Insales\Client::CLIENT_FIRST_ORDER_DATE;
        public const BOOK_VAR_CLIENT_LAST_ORDER_DATE = Model\Insales\Client::CLIENT_LAST_ORDER_DATE;
        public const BOOK_VAR_CLIENT_ORDER_COUNT = Model\Insales\Client::CLIENT_ORDER_COUNT;
        public const BOOK_VAR_CLIENT_ORDER_PAYMENT = Model\Insales\Client::CLIENT_ORDER_PAYMENT;
        public const BOOK_VAR_CLIENT_GROUP = Model\Insales\Client::CLIENT_GROUP;
        
        public function __construct(
            private readonly DashMailClientInterface $client,
            private readonly ApplicationRepositoryInterface $applicationRepository,
            private readonly TranslatorInterface $translator
        )
        {
        }
    
        public function __invoke(CreateAddressBookCommand $command)
        {
            
            $application = $command->getApplication();
            
            $this->client->initializeApplication($application);
            
            $fields = [
                'name' => $command->getTitle(),
                'fields' => \json_encode(
                    [
                        [
                            'type' => 'text',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.name'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_NAME,
                        ],
                        [
                            'type' => 'text',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.last_name'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_LAST_NAME,
                        ],
                        [
                            'type' => 'text',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.second_name'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_SECOND_NAME,
                        ],
                        [
                            'type' => 'text',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.phone'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_PHONE,
                        ],
                        [
                            'type' => 'date',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.first_order_date'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_FIRST_ORDER_DATE,
                        ],
                        [
                            'type' => 'date',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.last_order_date'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_LAST_ORDER_DATE,
                        ],
                        [
                            'type' => 'text',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.order_count'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_ORDER_COUNT,
                        ],
                        [
                            'type' => 'text',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.order_payment'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_ORDER_PAYMENT,
                        ],
                        [
                            'type' => 'text',
                            'title' => $this->translator->trans('dasha_mail.create_book.fields.client_group'),
                            'req' => 'off',
                            'var' => self::BOOK_VAR_CLIENT_GROUP,
                        ],
                    ],
                )
            ];

            $bookId = $this->client->createAddressBook($fields);

            $application->getOptions()
                ->setAddressBookId($bookId)
                ->setAddressBookTitle($command->getTitle())
            ;

            $this->applicationRepository->update($application);
        }
    }