<?php

namespace Imponeer\Properties\Helper;

use Imponeer\Properties\PropertiesSettings;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ServiceHelper
{

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public static function getTranslator(): TranslatorInterface {
		$translator = PropertiesSettings::getContainer()->get(TranslatorInterface::class);
		assert($translator instanceof TranslatorInterface);

		return $translator;
	}

	public static function getLogger(): ?LoggerInterface
	{
		try {
			$logger = PropertiesSettings::getContainer()->get(LoggerInterface::class);
		} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
			return null;
		}

		assert($logger instanceof LoggerInterface);

		return $logger;
	}

}