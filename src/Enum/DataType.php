<?php

declare(strict_types=1);

namespace Imponeer\Properties\Enum;

use Imponeer\Properties\AbstractType;
use Imponeer\Properties\Attribute\LinkedCaseType;
use Imponeer\Properties\DeprecatedTypes\CurrencyType;
use Imponeer\Properties\DeprecatedTypes\EmailType;
use Imponeer\Properties\DeprecatedTypes\FileType as DeprecatedFileType;
use Imponeer\Properties\DeprecatedTypes\FormSectionCloseType;
use Imponeer\Properties\DeprecatedTypes\FormSectionType;
use Imponeer\Properties\DeprecatedTypes\ImageType;
use Imponeer\Properties\DeprecatedTypes\MtimeType;
use Imponeer\Properties\DeprecatedTypes\SourceType;
use Imponeer\Properties\DeprecatedTypes\StimeType;
use Imponeer\Properties\DeprecatedTypes\TimeOnlyType;
use Imponeer\Properties\DeprecatedTypes\TxtboxType;
use Imponeer\Properties\DeprecatedTypes\UrllinkType;
use Imponeer\Properties\DeprecatedTypes\UrlType;
use Imponeer\Properties\Exceptions\SpecifiedDataTypeNotFoundException;
use Imponeer\Properties\Types\ArrayType;
use Imponeer\Properties\Types\BooleanType;
use Imponeer\Properties\Types\DateTimeType;
use Imponeer\Properties\Types\FileType;
use Imponeer\Properties\Types\FloatType;
use Imponeer\Properties\Types\IntegerType;
use Imponeer\Properties\Types\ListType;
use Imponeer\Properties\Types\ObjectType;
use Imponeer\Properties\Types\OtherType;
use Imponeer\Properties\Types\StringType;
use ReflectionEnum;
use ReflectionEnumBackedCase;

/**
 * Enum containing data type constants for properties
 */
enum DataType: int
{
    #[LinkedCaseType(StringType::class)]
    case STRING = 2; // XOBJ_TXTBOX

	#[LinkedCaseType(IntegerType::class)]
    case INTEGER = 3; // XOBJ_INT

	#[LinkedCaseType(FloatType::class)]
    case FLOAT = 201; // XOBJ_FLOAT

	#[LinkedCaseType(BooleanType::class)]
    case BOOLEAN = 105;

	#[LinkedCaseType(FileType::class)]
    case FILE = 104;

	#[LinkedCaseType(DateTimeType::class)]
    case DATETIME = 11; // XOBJ_LTIME

	#[LinkedCaseType(ArrayType::class)]
    case ARRAY = 6; // XOBJ_ARRAY

	#[LinkedCaseType(ListType::class)]
    case LIST = 101; // XOBJ_SIMPLE_ARRAY

	#[LinkedCaseType(ObjectType::class)]
    case OBJECT = 12;

	#[LinkedCaseType(OtherType::class)]
    case OTHER = 7; // XOBJ_OTHER

	#[LinkedCaseType(DeprecatedFileType::class)]
    case DEP_FILE = 204; // XOBJ_FILE

	#[LinkedCaseType(TxtboxType::class)]
    case DEP_TXTBOX = 1; // XOBJ_TXTBOX (deprecated)

	#[LinkedCaseType(UrlType::class)]
    case DEP_URL = 4; // XOBJ_URL

	#[LinkedCaseType(EmailType::class)]
    case DEP_EMAIL = 5; // XOBJ_EMAIL

	#[LinkedCaseType(SourceType::class)]
    case DEP_SOURCE = 8; // XOBJ_SOURCE

	#[LinkedCaseType(StimeType::class)]
    case DEP_STIME = 9; // XOBJ_STIME

	#[LinkedCaseType(MtimeType::class)]
    case DEP_MTIME = 10; // XOBJ_MTIME

	#[LinkedCaseType(CurrencyType::class)]
    case DEP_CURRENCY = 200; // XOBJ_CURRENCY

	#[LinkedCaseType(TimeOnlyType::class)]
    case DEP_TIME_ONLY = 202; // XOBJ_TIME_ONLY

	#[LinkedCaseType(UrllinkType::class)]
    case DEP_URLLINK = 203; // XOBJ_URLLINK

	#[LinkedCaseType(ImageType::class)]
    case DEP_IMAGE = 205; // XOBJ_IMAGE

	#[LinkedCaseType(FormSectionType::class)]
    case DEP_FORM_SECTION = 210; // XOBJ_FORM_SECTION

	#[LinkedCaseType(FormSectionCloseType::class)]
    case DEP_FORM_SECTION_CLOSE = 211; // XOBJ_FORM_SECTION_CLOSE


	/**
	 * @return array<int, class-string<AbstractType>>
	 */
	private static function getTypeClassMap(): array
	{
		static $result = null;

		if ($result !== null) {
			return $result;
		}

		$result = [];
		$refl = new ReflectionEnum(self::class);
		foreach ($refl->getCases() as $case) {
			assert($case instanceof ReflectionEnumBackedCase);

			$attributes = $case->getAttributes(LinkedCaseType::class);
			if (empty($attributes)) {
				continue;
			}

			assert($attributes[0] instanceof LinkedCaseType);
			$result[$case->getBackingValue()] = $attributes[0]->class;
		}

		return $result;
	}

	/**
	 * @throws SpecifiedDataTypeNotFoundException
	 */
	public function getTypeClass(): string {
		$map = self::getTypeClassMap();

		if (isset($map[$this->value])) {
			return $map[$this->value];
		}

		throw new SpecifiedDataTypeNotFoundException($this->value);
	}

}
