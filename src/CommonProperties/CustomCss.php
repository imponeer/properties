<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
use Imponeer\Properties\Types\StringType;

/**
 * Custom CSS field type
 *
 * @package Imponeer\Properties\CommonVariables
 */
class CustomCss implements CommonPropertyInterface {
	/**
	 * @inheritDoc
	 */
	public function parseValue(mixed $default): mixed {
		return $default !== 'notdefined' ? $default : 0;
	}

	/**
	 * @inheritDoc
	 */
	public function getDataType(): string {
		return StringType::class;
	}

	/**
	 * @inheritDoc
	 */
	public function isRequired(): bool {
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function getOtherConfig(): ?array {
		return [
			'form_caption' => _CO_ICMS_CUSTOM_CSS,
			'maxLength' => null,
			'options' => '',
			'multilingual' => false,
			'form_desc' => _CO_ICMS_CUSTOM_CSS_DSC,
			'sortby' => false,
			'persistent' => true
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getControl(): ?array {
		return [
			'name' => 'textarea',
			'form_editor'=>'textarea'
		];
	}

}