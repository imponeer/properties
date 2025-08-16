<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;
use Imponeer\Properties\Internal\Helper\HtmlSanitizerHelper;

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
        return HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    /**
     * @inheritDoc
     */
    public function getForForm(): string
    {
        return HtmlSanitizerHelper::prepareForHtml($this->value);
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
            return (int)$value;
        }
        if (!is_string($value)) {
            return 0;
        }
        if (preg_match('/(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)/u', $value, $ret)) {
			[, $year, $month, $day, $hour, $min, $sec] = array_map('intval', $ret);
			$ts = gmmktime($hour, $min, $sec, $month, $day, $year);
			$time = ($ts === false || $ts < 0) ? 0 : $ts;
		} else {
            $time = (int) strtotime($value);
        }
        return ($time < 0) ? 0 : $time;
    }
}
