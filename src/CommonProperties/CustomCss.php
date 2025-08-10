<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\Helper\ServiceHelper;
use Imponeer\Properties\Types\StringType;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
	 *
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
    public function getOtherConfig(): ?array
    {
        return [
            'form_caption' => ServiceHelper::getTranslator()->trans('_CO_ICMS_CUSTOM_CSS', [], 'common'),
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => ServiceHelper::getTranslator()->trans('_CO_ICMS_CUSTOM_CSS_DSC', [], 'common'),
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
