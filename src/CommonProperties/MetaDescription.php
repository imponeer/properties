<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
use Imponeer\Properties\Types\StringType;

/**
 * Meta description field type
 *
 * @package Imponeer\Properties\CommonVariables
 */
class MetaDescription implements CommonPropertyInterface
{
    /**
     * @inheritDoc
     */
    public function parseValue(mixed $default): mixed
    {
        return $default !== 'notdefined' ? $default : 0;
    }

    /**
     * @inheritDoc
     */
    public function getDataType(): string
    {
        return StringType::class;
    }

    /**
     * @inheritDoc
     */
    public function isRequired(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getOtherConfig(): ?array
    {
        return [
            'form_caption' => _CO_ICMS_META_DESCRIPTION,
            'maxLength' => 160,
            'options' => '',
            'multilingual' => false,
            'form_desc' => _CO_ICMS_META_DESCRIPTION_DSC,
            'sortby' => false,
            'persistent' => true
        ];
    }

    /**
     * @inheritDoc
     */
    public function getControl(): ?array
    {
        return [
            'name' => 'textarea',
            'form_editor' => 'textarea'
        ];
    }
}
