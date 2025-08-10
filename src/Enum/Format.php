<?php

declare(strict_types=1);

namespace Imponeer\Properties\Enum;

/**
 * Enum containing format types for property values
 */
enum Format: string
{
    case SHOW = 's';
    case PREVIEW = 'p';
    case EDIT = 'e';
    case FORM_PREVIEW = 'f';
    case RAW = '';

    public static function fromString(string $format): self
    {
        $format = trim($format);
        return match (strlen($format)) {
            0 => self::RAW,
            1 => self::tryFrom(strtolower($format)) ?? self::RAW,
            default => self::tryFrom(strtolower($format[0])) ?? self::RAW,
        };
    }
}
