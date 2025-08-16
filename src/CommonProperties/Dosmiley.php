<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\Internal\Facades\Translator;
use Imponeer\Properties\Types\IntegerType;

class Dosmiley implements CommonPropertyInterface
{
    public function parseValue(mixed $default): mixed
    {
        return $default !== 'notdefined' ? $default : 0;
    }

    public function getDataType(): string
    {
        return IntegerType::class;
    }

    public function isRequired(): bool
    {
        return false;
    }

	public function getOtherConfig(): ?array
    {
        return [
            'form_caption' => Translator::trans('_CM_DOSMILEY', [], 'comment'),
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => '',
            'sortby' => false,
            'persistent' => true
        ];
    }

    public function getControl(): ?array
    {
        return [
            'name' => 'yesno'
        ];
    }
}
