<?php

namespace Imponeer\Properties\Facades;

use Imponeer\Properties\Service\ServiceLocator;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @internal
 */
final class Translator
{
	private function __construct()
	{
	}

	public static function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
	{
		return self::getTranslator()->trans($id, $parameters, $domain, $locale);
	}

	private static function getTranslator(): TranslatorInterface
	{
		/** @noinspection PhpUnhandledExceptionInspection */
		$translator = ServiceLocator::getInstance()->get(TranslatorInterface::class);
		assert($translator instanceof TranslatorInterface);

		return $translator;
	}

}