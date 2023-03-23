<?php
	
	namespace App\Core\Ports\Http\Configuration\Action;
	
	use App\Core\Application\Command\Insales\GenerateFailedEmailReport\GenerateFailedEmailReportCommand;
	use App\Core\Application\Query\Insales\GetApplication\GetApplicationQuery;
	use App\Core\Domain\Infrastructure\Annotation\Access;
	use App\Core\Domain\Infrastructure\HandlerInterface;
	use Symfony\Component\HttpFoundation\BinaryFileResponse;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\ResponseHeaderBag;
	use Symfony\Component\Routing\Annotation\Route;
	
	/**
	 * Загрузка файла с проблемными email
	 *
	 * Class DownloadFailEmailAction
	 * @package App\Core\Ports\Http\Configuration\Action
	 */
	final class DownloadFailEmailAction
	{
		public const ROUTE_NAME = 'configuration.action.download-fail-emails';
		
		/**
		 * @param HandlerInterface $handler
		 */
		public function __construct(
			private readonly HandlerInterface $handler
		)
		{
		}
		
		#[Route(
			path: '/configuration/{uuid}/action/download-fail-emails',
			name: self::ROUTE_NAME,
			methods: [Request::METHOD_GET]
		)]
		#[Access(name: 'uuid')]
		public function __invoke(string $uuid, Request $request): BinaryFileResponse
		{
			
			#print_r($request->server->get('HTTP_USER_AGENT'));
			#die();
			$application = $this->handler->handle(
				new GetApplicationQuery(
					$uuid
				)
			);
			
			/** @var \Symfony\Component\HttpFoundation\File\File $file */
			$file = $this->handler->handle(
				new GenerateFailedEmailReportCommand(
					$application
				)
			);
			
			$response = new BinaryFileResponse($file->getRealPath());
			
			$response->setContentDisposition(
				ResponseHeaderBag::DISPOSITION_ATTACHMENT,
				$file->getFilename()
			);
			
			return $response;
		}
	}