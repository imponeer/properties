<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
use Imponeer\Properties\Types\IntegerType;

/**
 * Weight field type
 *
 * @package Imponeer\Properties\CommonVariables
 */
class Weight implements CommonPropertyInterface {
    /**
     * @inheritDoc
     */
    public function parseValue(mixed $default): mixed {
        return $default !== 'notdefined' ? $default : 0;
    }

    /**
     * @inheritDoc
     */
    public function getDataType(): string {
        return IntegerType::class;
    }

    /**
     * @inheritDoc
     */
    public function isRequired(): bool {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getOtherConfig(): ?array {
        return [
            'form_caption' => _CO_ICMS_WEIGHT_FORM_CAPTION,
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => '',
            'sortby' => true,
            'persistent' => true
        ];
    }

    /**
     * @inheritDoc
     */
    public function getControl(): ?array {
        return null;
    }

}