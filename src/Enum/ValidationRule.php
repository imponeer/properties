<?php

declare(strict_types=1);

namespace Imponeer\Properties\Enum;

/**
 * Enum containing validation rules for properties
 */
enum ValidationRule: string
{
    /**
     * Validation rule for emails
     */
    case EMAIL = '/^[a-z0-9]+([_\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i';

    /**
     * Validation rule for links
     */
    case LINKS = '#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i';

}
