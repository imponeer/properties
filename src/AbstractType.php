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
     * Default value
     *
     * @var mixed
     */
    public mixed $defaultValue = null;

    /**
     * Is required?
     *
     * @var bool
     */
    public bool $required = false;

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
     *
     * @var object|null
     */
    protected object|null $parent = null;

    /**
     * Constructor.
     *
     * @param object $parent Property support implemented class
     * @param mixed $defaultValue Default value
     * @param bool $required Is required?
     * @param null|array $otherCfg Other config data
     */
    public function __construct(&$parent, $defaultValue = null, $required = false, $otherCfg = null)
    {
        $this->parent = &$parent;
        if ($otherCfg !== null) {
            foreach ($otherCfg as $key => $value) {
                if (isset($this->$key)) {
                    $this->$key = $value;
                }
            }
            $this->_vars[$key] = $otherCfg;
            if (is_string($this->possibleOptions)) {
                $this->possibleOptions = explode('|', $this->possibleOptions);
            }
        }
        $this->defaultValue = $this->clean($defaultValue);
        $this->required = $required;
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
     * @param mixed $key Key to read
     *
     * @throws PropertyIsLockedException
     * @throws ValueIsNotInPossibleValuesListException
     */
    public function setFromRequest($key)
    {
        if (is_array($key)) {
            $value = &$_REQUEST;
            foreach ($key as $k) {
                $value = &$value[$k];
            }
            $this->set($value);
        } else {
            $this->set($_REQUEST[$key]);
        }
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
            throw new PropertyIsLockedException();
        }
        if (!empty($this->possibleOptions) && !in_array($value, $this->possibleOptions, true)) {
            throw new ValueIsNotInPossibleValuesListException();
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
     *
     * @return bool
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
    public function reset()
    {
        $this->value = $this->defaultValue;
        $this->changed = false;
    }

    /**
     * Is defined (is set)?
     *
     * @return boolean
     */
    abstract public function isDefined();

    /**
     * Return for display
     *
     * @return string
     */
    abstract public function getForDisplay();

    /**
     * Return value for editing
     *
     * @return string
     */
    abstract public function getForEdit();

    /**
     * Get value for form
     *
     * @return string
     */
    abstract public function getForForm();

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
