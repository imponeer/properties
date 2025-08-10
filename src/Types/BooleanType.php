<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;
use Imponeer\Properties\Helper\HtmlSanitizerHelper;
use Imponeer\Properties\Helper\ServiceHelper;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class BooleanType extends AbstractType
{
    public function isDefined(): bool
    {
        return true;
    }

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function getForDisplay(): string
    {
		if ($this->value) {
			return ServiceHelper::getTranslator()->trans('_YES', [], 'common');
		}

		return ServiceHelper::getTranslator()->trans('_NO', [], 'common');
	}

    public function getForEdit(): string
    {
        return HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    public function getForForm(): string
    {
        return HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    protected function clean(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (!is_string($value)) {
			if (is_object($value)) {
				return true;
			}

			if (is_null($value)) {
				return false;
			}

			return (bool)(int)$value;
        }

        $value = strtolower($value);
        return ($value === 'yes') || ($value === 'true');
    }
}
