<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

/**
 * Defines date & time type
 *
 * @package Imponeer\Properties\Types
 */
class DateTimeType extends AbstractType
{
    /**
     * Format for output
     *
     * @var string
     */
    public string $format = 'r';

    /**
     * @inheritDoc
     */
    public function isDefined(): bool
    {
        return is_int($this->value) && ($this->value > 0);
    }

    /**
     * @inheritDoc
     */
    public function getForDisplay(): string
    {
        return date($this->format ?? 'r', $this->value);
    }

    /**
     * @inheritDoc
     */
    public function getForEdit(): string
    {
        return \Imponeer\Properties\Helper\HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    /**
     * @inheritDoc
     */
    public function getForForm(): string
    {
        return \Imponeer\Properties\Helper\HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    /**
     * @inheritDoc
     */
    protected function clean(mixed $value): int
    {
        if (is_int($value)) {
            return $value;
        }
        if ($value === null) {
            return 0;
        }
        if (is_numeric($value)) {
            return intval($value);
        }
        if (!is_string($value)) {
            return 0;
        }
        if (preg_match('/(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)/ui', $value, $ret)) {
            $time = gmmktime($ret[4], $ret[5], $ret[6], $ret[2], $ret[3], $ret[1]);
        } else {
            $time = (int) strtotime($value);
        }
        return ($time < 0) ? 0 : $time;
    }
}
