<?php

namespace Imponeer\Properties\Helper;

use const Imponeer\Properties\_CHARSET;

class HtmlSanitizerHelper
{
    /**
     * Prepares a value for HTML output, matching legacy str_replace+htmlspecialchars pattern.
     *
     * @param string|null $value
     * @param int $flags
     * @param string|null $encoding
     * @return string
     */
    public static function prepareForHtml(?string $value, int $flags = ENT_QUOTES, ?string $encoding = null): string
    {
        if ($encoding === null) {
            $encoding = defined('_CHARSET') ? _CHARSET : 'UTF-8';
        }
        return str_replace(
            ['&amp;', '&nbsp;'],
            ['&', '&amp;nbsp;'],
            @htmlspecialchars($value, $flags, $encoding)
        );
    }
}
