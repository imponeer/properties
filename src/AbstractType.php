<?php

declare(strict_types=1);

namespace Imponeer\Properties;

use Imponeer\Properties\Exceptions\PropertyIsLockedException;
use Imponeer\Properties\Exceptions\ValueIsNotInPossibleValuesListException;
use JetBrains\PhpStorm\Deprecated;
use ReflectionClass;

abstract class AbstractType
{
    /**
     * Is locked from modifications?
     *
     * @var bool
     */
    public bool $locked = false;

    /**
     * Possible options
     *
     * @var array
     */
    public array $possibleOptions = [];

    /**
     * Is changed?
     *
     * @var bool
     */
    public bool $changed = false;

    /**
     * Not loaded?
     *
     * @var bool
     */
    public bool $not_loaded = false;

    /**
     * Data handler (used for linking data with database)
     *
     * @var string|null
     */
    public ?string $data_handler = null;

    /**
     * Hide from user?
     *
     * @var bool
     */
    public bool $hide = false;

    /**
     * Current value
     *
     * @var mixed
     */
    protected mixed $value = null;

    /**
     * Parent

    /**
     * Constructor.
     *
     * @param object $parent Property support implemented class
     * @param mixed $defaultValue Default value
     * @param bool $required Is required?
     * @param null|array $otherCfg Other config data
     */
    public function __construct(
		protected object $parent,
		protected readonly string $name,
		protected mixed $defaultValue = null,
		protected bool $required = false,
		null|array $otherCfg = null
	) {
        $this->parent = &$parent;
        if ($otherCfg !== null) {
            foreach ($otherCfg as $key => $value) {
                if (isset($this->$key)) {
					$this->$key = match ($key) {
						'possibleOptions' => is_array($value) ? $value : explode('|', $value),
						default => $value,
					};
                }
            }
        }
        $this->defaultValue = $this->clean($defaultValue);
        $this->value = $defaultValue;
    }

    /**
     * Cleans current value
     *
     * @param mixed $value Value to clean
     */
    abstract protected function clean($value);

    /**
     * Set var from request
     *
     * @param array<string|int>|string $key Key to read
     *
     * @throws PropertyIsLockedException
     * @throws ValueIsNotInPossibleValuesListException
     */
    public function setFromRequest(array|string $key): void
	{
		$parsedBody = PropertiesSettings::getRequest()->getParsedBody() ?? [];

		$requestValues = [
			...PropertiesSettings::getRequest()->getQueryParams(),
			...(array)$parsedBody
		];

        if (is_array($key)) {
			$value = $this->resolveArrayPath($requestValues, $key);
        } else {
			$value = $requestValues[$key] ?? null;
        }

		$this->set($value);
	}

	protected function resolveArrayPath(array $data, array $path): mixed
	{
		$value = $data;
		foreach ($path as $k) {
			if (!is_array($value) || !array_key_exists($k, $value)) {
				$value = null;
				break;
			}
			$value = $value[$k];
		}

		return $value;
	}

    /**
     * Set value
     *
     * @param $value Value to set
     *
     * @throws PropertyIsLockedException
     * @throws ValueIsNotInPossibleValuesListException
     */
    public function set($value)
    {
        if ($this->locked) {
            throw new PropertyIsLockedException($this->name);
        }
        if (!empty($this->possibleOptions) && !in_array($value, $this->possibleOptions, true)) {
            throw new ValueIsNotInPossibleValuesListException($this->name);
        }

        $clean = $this->clean($value);

        if ($clean === $this->value) {
            return;
        }
        $this->value = $clean;
        $this->changed = true;
        if ($this->not_loaded) {
            $this->not_loaded = false;
        }
    }

    /**
     * Returns if current type is one of deprecated types
     */
    public function isDeprecatedType(): bool
    {
        $refClass = new ReflectionClass($this);
        $attributes = $refClass->getAttributes(Deprecated::class);

        return !empty($attributes);
    }

    /**
     * Reset value to default
     */
    public function reset(): void
	{
        $this->value = $this->defaultValue;
        $this->changed = false;
    }

    /**
     * Is defined (is set)?
     */
    abstract public function isDefined(): bool;

    /**
     * Return for display
     */
    abstract public function getForDisplay(): string;

    /**
     * Return value for editing
     */
    abstract public function getForEdit(): string;

    /**
     * Get value for form
     */
    abstract public function getForForm(): string;

    /**
     * Get value without formating
     *
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }
}
