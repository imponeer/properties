<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;
use Imponeer\Properties\Exceptions\ValidationRuleNotPassedException;
use JsonException;
use stdClass;

class StringType extends AbstractType
{
    public bool $not_gpc = false;
    public string $validateRule = '';
    public ?string $sourceFormating = null;
    public ?int $maxLength = null;
    public bool $autoFormatingDisabled = false;

    public function isDefined(): bool
    {
        return strlen($this->value) > 0;
    }

    public function getForDisplay(): string
    {
        if ($this->autoFormatingDisabled) {
            $ret = \Imponeer\Properties\Helper\HtmlSanitizerHelper::prepareForHtml($this->value);
            if (method_exists($this->parent, 'formatForML')) {
                return $this->formatForML($ret);
            }
            return $ret;
        }
        $html = (isset($this->parent->html) && $this->parent->html) ? 1 : 0;
        if (!$html) {
            return $this->value;
        }
        $xcode = (!isset($this->parent->doxcode) || $this->parent->doxcode) ? 1 : 0;
        $smiley = (!isset($this->parent->dosmiley) || $this->parent->dosmiley) ? 1 : 0;
        $image = (!isset($this->parent->doimage) || $this->parent->doimage) ? 1 : 0;
        $br = (!isset($this->parent->dobr) || $this->parent->dobr) ? 1 : 0;

        $ts = icms_core_Textsanitizer::getInstance();
        return $ts->displayTarea($this->value, $html, $smiley, $xcode, $image, $br);
    }

    public function getForEdit(): string
    {
        return \Imponeer\Properties\Helper\HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    public function getForForm(): string
    {
        return \Imponeer\Properties\Helper\HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    /**
     * @throws JsonException
     * @throws ValidationRuleNotPassedException
     */
    protected function clean(mixed $value): string
    {
        if (!is_string($value)) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            } elseif ($value instanceof stdClass) {
                $value = json_encode((array)$value, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            } else {
                $value = (string)$value;
            }
        }
        if (!empty($this->value) && !empty($this->validateRule)) {
            if (!preg_match($this->validateRule, $value)) {
                throw new ValidationRuleNotPassedException($value);
            }

            if (empty($this->sourceFormating)) {
                $value = icms_core_DataFilter::censorString($value);
            }
        }
        if (($this->maxLength > 0) && (mb_strlen($value) > $this->maxLength)) {
            trigger_error('Value was shortered', E_USER_WARNING);
            $value = mb_substr($value, 0, $this->maxLength);
        }
        return $value;
    }
}
