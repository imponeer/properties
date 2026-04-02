<?php

declare(strict_types=1);

namespace Imponeer\Properties\Internal;

use Imponeer\Properties\Contracts\CensorStringInterface;

/**
 * Default implementation of string censoring that doesn't modify the text
 *
 * @internal
 */
final class DefaultCensorString implements CensorStringInterface
{
    public function __invoke(string $text): string
    {
        return $text;
    }
}
