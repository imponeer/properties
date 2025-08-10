<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\Helper\ServiceHelper;
use Imponeer\Properties\Types\ArrayType;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Hierarchy path field type
 *
 * @package Imponeer\Properties\CommonVariables
 */
class HierarchyPath implements CommonPropertyInterface
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
        return ArrayType::class;
    }

    /**
     * @inheritDoc
     */
    public function isRequired(): bool
    {
        return false;
    }


	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function getOtherConfig(): ?array
    {
        return [
            'form_caption' => ServiceHelper::getTranslator()->trans('_CO_ICMS_HIERARCHY_PATH', [], 'common'),
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => ServiceHelper::getTranslator()->trans('_CO_ICMS_HIERARCHY_PATH_DSC', [], 'common'),
            'sortby' => false,
            'persistent' => true
        ];
    }

    /**
     * @inheritDoc
     */
    public function getControl(): ?array
    {
        return null;
    }
}
