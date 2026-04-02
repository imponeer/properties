<?php

declare(strict_types=1);

namespace Imponeer\Properties\Contracts;

/**
 * Interface for string censoring functionality
 */
interface CensorStringInterface
{
    /**
     * Censor a string
     *
     * @param string $text The text to censor
     * @return string The censored text
     */
    public function censorString(string $text): string;
}
