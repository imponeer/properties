<?php

namespace Imponeer\Properties\Helper;

use Imponeer\Properties\PropertiesSettings;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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

}