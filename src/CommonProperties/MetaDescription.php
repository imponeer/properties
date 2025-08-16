<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\Internal\Facades\Translator;
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

	public function getOtherConfig(): ?array
    {
        return [
            'form_caption' => Translator::trans('_CO_ICMS_META_DESCRIPTION', [], 'common'),
            'maxLength' => 160,
            'options' => '',
            'multilingual' => false,
            'form_desc' => Translator::trans('_CO_ICMS_META_DESCRIPTION_DSC', [], 'common'),
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
