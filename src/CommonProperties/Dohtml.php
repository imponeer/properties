<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\Helper\ServiceHelper;
use Imponeer\Properties\Types\IntegerType;

/**
 * Do HTML field type
 *
 * @package Imponeer\Properties\CommonVariables
 */
class Dohtml implements CommonPropertyInterface
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
        return IntegerType::class;
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
            'form_caption' =>  ServiceHelper::getTranslator()->trans('_CM_DOHTML', [], 'comment'),
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => '',
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
            'name' => 'yesno'
        ];
    }
}
