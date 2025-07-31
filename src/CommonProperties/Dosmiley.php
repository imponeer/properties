<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
use Imponeer\Properties\Types\IntegerType;

class Dosmiley implements CommonPropertyInterface {
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
        if (!defined('_CM_DOSMILEY')) {
            icms_loadLanguageFile('core', 'comment');
        }
        return [
            'form_caption' => _CM_DOSMILEY,
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => '',
            'sortby' => false,
            'persistent' => true
        ];
    }

    public function getControl(): ?array {
        return [
            'name' => 'yesno'
        ];
    }
}