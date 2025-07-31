<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
use Imponeer\Properties\Types\IntegerType;

class Counter implements CommonPropertyInterface {
    public function parseValue(mixed $default): mixed {
        return $default !== 'notdefined' ? $default : 0;
    }

    public function getDataType(): string {
        return IntegerType::class;
    }

    public function isRequired(): bool {
        return false;
    }

    public function getOtherConfig(): ?array {
        return [
            'form_caption' => _CO_ICMS_COUNTER_FORM_CAPTION,
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => '',
            'sortby' => false,
            'persistent' => true
        ];
    }

    public function getControl(): ?array {
        return null;
    }
}