<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
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
        if (!defined('_CM_DOAUTOWRAP')) {
            icms_loadLanguageFile('core', 'comment');
        }
        return [
            'form_caption' => _CM_DOHTML,
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
