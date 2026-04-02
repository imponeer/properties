<?php

namespace Imponeer\Properties\Internal\Facades;

use Imponeer\Properties\Contracts\CensorStringInterface;
use Imponeer\Properties\Service\ServiceLocator;

/**
 * @internal
 */
final class CensorString
{
    private function __construct()
    {
    }

    public static function censorString(string $text): string
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $censor = ServiceLocator::getInstance()->get(CensorStringInterface::class);
        assert($censor instanceof CensorStringInterface);

        return $censor->censorString($text);
    }
}
