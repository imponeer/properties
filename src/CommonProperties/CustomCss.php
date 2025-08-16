<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\Facades\Translator;
use Imponeer\Properties\Types\StringType;

/**
 * Custom CSS field type
 *
 * @package Imponeer\Properties\CommonVariables
 */
class CustomCss implements CommonPropertyInterface
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
            'form_caption' => Translator::trans('_CO_ICMS_CUSTOM_CSS', [], 'common'),
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => Translator::trans('_CO_ICMS_CUSTOM_CSS_DSC', [], 'common'),
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
