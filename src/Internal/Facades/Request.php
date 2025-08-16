<?php

namespace Imponeer\Properties\Internal\Facades;

use Imponeer\Properties\Service\ServiceLocator;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @internal
 */
final class Request
{

	private function __construct()
	{
	}

	public static function getQueryParams(): array
	{
		return self::getRequest()->getQueryParams();
	}

	public static function getUploadedFiles(): array
	{
		return self::getRequest()->getUploadedFiles();
	}

	private static function getRequest(): ServerRequestInterface
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$request = ServiceLocator::getInstance()->get(ServerRequestInterface::class);
		assert($request instanceof ServerRequestInterface);

		return $request;
	}

	public static function getParsedBody(): object|array|null
	{
		return self::getRequest()->getParsedBody();
	}
}