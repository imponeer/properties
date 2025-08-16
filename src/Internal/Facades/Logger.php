<?php

namespace Imponeer\Properties\Internal\Facades;

use Imponeer\Properties\Service\ServiceLocator;
use Psr\Log\LoggerInterface;

/**
 * @internal
 */
final class Logger
{
	private function __construct()
	{
	}

	public static function warning(string $message, array $context = []): void
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$logger = ServiceLocator::getInstance()->get(LoggerInterface::class);
		assert($logger instanceof LoggerInterface);

		$logger->warning($message, $context);
	}

}