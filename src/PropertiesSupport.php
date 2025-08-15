<?php

declare(strict_types=1);

namespace Imponeer\Properties;

use Imponeer\Properties\Enum\DataType;
use Imponeer\Properties\Enum\Format;
use Imponeer\Properties\Exceptions\PropertyIsLockedException;
use Imponeer\Properties\Exceptions\SpecifiedDataTypeNotFoundException;
use Imponeer\Properties\Exceptions\UndefinedVariableException;
use Imponeer\Properties\Exceptions\ValueIsNotInPossibleValuesListException;
use Imponeer\Properties\Helper\ServiceHelper;
use JetBrains\PhpStorm\Deprecated;

/**
 * Contains methods for dealing with object properties
 *
 * @copyright   The ImpressCMS Project http://www.impresscms.org/
 * @license     MIT https://opensource.org/licenses/MIT
 * @author      mekdrop@impresscms.org
 */
trait PropertiesSupport
{
    /**
     * Vars configuration
     *
     * @var array<string, AbstractType>
     */
    protected array $vars = [];

    /**
     * Changed vars count
     *
     * @var int
     */
    protected int $changed = 0;

	/**
	 * Assigns values from array to vars
	 *
	 * @param array $values Assoc array with keys and values to assign
	 *
	 * @throws PropertyIsLockedException
	 * @throws ValueIsNotInPossibleValuesListException
	 */
    public function assignVars(array $values): void
    {
        foreach ($this->vars as $key => $var) {
            $value = $values[$key] ?? null;
            $this->vars[$key]->set($value);
        }
    }

	/**
	 * Inits common var
	 *
	 * @param string $varname Var name
	 * @param bool $displayOnForm Display on form
	 * @param string $default Default value
	 *
	 * @throws SpecifiedDataTypeNotFoundException
	 */
	#[Deprecated(reason: '$this->initCommonVar() will be removed in the future!', replacement: '$this->initVar()')]
    public function initCommonVar(string $varname, bool $displayOnForm = true, string $default = 'notdefined'): void
    {
        $class = "\\Imponeer\\Properties\\CommonProperties\\" . implode(
            '',
            array_map(
                'ucfirst',
                array_map(
                    'strtolower',
                    explode('_', $varname)
                )
            )
        );
        $instance = new $class();
        $this->initVar(
            $varname,
            $instance->getDataType(),
            $instance->parseValue($default),
            $instance->isRequired(),
            $instance->getOtherConfig() + compact('displayOnForm')
        );
        if (method_exists($this, 'setControl') && ($control = $instance->getControl())) {
            $this->setControl($varname, $control);
        }
		$this->setVarInfo($varname, 'displayOnSingleView', false);
    }

	/**
	 * @param string|string[] $field
	 */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->setVarInfo()')]
	public function hideFieldFromSingleView(string|array $field): void
	{
		$this->setVarInfo($field, 'displayOnSingleView', false);
	}

	/**
	 * @param string|string[] $field
	 */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->setVarInfo()')]
	public function makeFieldReadOnly(string|array $field): void {
		$this->setVarInfo($field, 'readonly', true);
		$this->setVarInfo($field, 'displayOnForm', true);
	}

	/**
	 * @param string|string[] $field
	 */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->setVarInfo()')]
	public function hideFieldFromForm(array|string $field): void
	{
		$this->setVarInfo($field, 'displayOnForm', false);
	}

	/**
	 * @param string|string[] $field
	 */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->setVarInfo()')]
	public function setFieldAsRequired(array|string $field, $required = true): void
	{
		$this->setVarInfo($field, 'required', $required);
	}

	/**
	 * @param string|string[] $field
	 */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->setVarInfo()')]
	public function setFieldForSorting(array|string $field): void
	{
		$this->setVarInfo($field, 'sortby', true);
	}

	/**
	 * @param string|string[] $field
	 */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->setVarInfo()')]
	public function showFieldOnForm(array|string $field): void {
		$this->setVarInfo($field, 'displayOnForm', true);
	}

	/**
	 * @param string|string[] $field
	 */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->setVarInfo()')]
	public function setAdvancedFormFields(array|string $field): void
	{
		$this->setVarInfo($field, 'advancedform', true);
	}

	/**
	 * Initialize var (property) for the object
	 *
	 * @param string $key Var name
	 * @param DataType|int|string $dataType Var data type (use DType enum or legacy constants DTYPE_* for specifying it!)
	 * @param mixed $defaultValue Default value
	 * @param bool $required Is Required?
	 * @param array|null $otherCfg /null $otherCfg  If there is, an assoc array with other configuration for var
	 *
	 * @throws SpecifiedDataTypeNotFoundException
	 */
    protected function initVar(
		string              $key,
		DataType|int|string $dataType,
		mixed               $defaultValue = null,
		bool                $required = false,
		array|null          $otherCfg = null
    ): void {
        if ($dataType instanceof DataType) {
            $class = $dataType->getTypeClass();
        } elseif (is_int($dataType)) {
            $case = DataType::tryFrom($dataType);
            if ($case === null) {
                throw new SpecifiedDataTypeNotFoundException($dataType);
            }
            $class = $case->getTypeClass();
        } else {
            $class = $dataType;
        }

        $this->vars[$key] = new $class(
			$this,
			$key,
			$defaultValue,
			$required,
			$otherCfg
		);
    }

    /**
     * Checks if var exists
     *
     * @param string $name Var name
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->vars[$name]);
    }

    /**
     * assign a value to a variable
     *
     * @access public
     * @param string $key name of the variable to assign
     * @param mixed $value value to assign
     */
    public function assignVar(string $key, mixed &$value): void
    {
        $this->vars[$key]->value = $value;
    }

    /**
     * Gets changes vars
     *
     * @return array
     */
    public function getChangedVars(): array
    {
        $changed = array();
        foreach ($this->vars as $key => $var) {
            if ($var->changed) {
                $changed[] = $key;
            }
        }
        return $changed;
    }

    /**
     * If is object variables has been changed?
     *
     * @return bool
     */
    public function isChanged(): bool
    {
        return $this->changed > 0;
    }

    /**
     * Gets an array with required but not specified vars
     *
     * @return array
     */
    public function getProblematicVars(): array
    {
        $names = array();
        foreach ($this->vars as $key => $var) {
            if ($var->required && ($var->isDefined() === false)) {
                $names[] = $key;
            }
        }
        return $names;
    }

    /**
     * Gets default values for all vars
     *
     * @return array
     */
    public function getDefaultVars(): array
    {
        $ret = [];
        foreach ($this->vars as $key => $var) {
            $ret[$key] = $var->defaultValue;
        }
        return $ret;
    }

	/**
	 * Returns the values of the specified variables
	 *
	 * @param mixed $keys An array containing the names of the keys to retrieve, or null to get all of them
	 * @param string|Format $format Format to use (see getVar)
	 * @param int $maxDepth Maximum level of recursion to use if some vars are objects themselves
	 * @return array associative array of key->value pairs
	 *
	 * @throws UndefinedVariableException
	 */
    public function getValues(mixed $keys = null, string|Format $format = Format::SHOW, int $maxDepth = 1): array
    {
        if (!isset($keys)) {
            $keys = array_keys($this->vars);
        }
        $vars = [];
        foreach ($keys as $key) {
            if (isset($this->vars[$key])) {
                if (is_object($this->vars[$key]->value) && ($this->vars[$key]->value instanceof PropertiesSupport)) {
                    if ($maxDepth) {
                        $vars[$key] = $this->vars[$key]->getValues(null, $format, $maxDepth - 1);
                    }
                } else {
                    $vars[$key] = $this->getVar($key, $format);
                }
            }
        }
        return $vars;
    }

	/**
	 * Returns a specific variable for the object in a proper format
	 *
	 * @access public
	 * @param string $name key of the object's variable to be returned
	 * @param string|Format $format format to use for the output
	 * @return mixed formatted value of the variable
	 *
	 * @throws UndefinedVariableException
	 */
    public function getVar(string $name, string|Format $format = Format::SHOW): mixed
    {
		if (!($format instanceof Format)) {
			$format = Format::fromString($format);
		}

		return match ($format) {
			Format::SHOW, Format::PREVIEW => $this->getVarForDisplay($name),
			Format::EDIT => $this->getVarForEdit($name),
			Format::FORM_PREVIEW => $this->getVarForForm($name),
			default => $this->__get($name),
		};
    }

    /**
     * Gets var value for displaying
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getVarForDisplay(string $name): mixed
    {
        return $this->vars[$name]->getForDisplay();
    }

    /**
     * Gets var value for editing
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getVarForEdit(string $name): mixed
    {
        return $this->vars[$name]->getForEdit();
    }

    /**
     * Gets var value for form
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getVarForForm(string $name): mixed
    {
        return $this->vars[$name]->getForForm();
    }

	/**
	 * Magic function to get property value by accessing it by name
	 *
	 * @param string $name
	 *
	 * @return mixed
	 *
	 * @throws UndefinedVariableException
	 */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case '_vars':
            case 'vars':
                if (isset($this->vars[$name])) {
                    return $this->vars[$name]->get();
                }

				return $this->vars;
			case 'cleanVars':
                return $this->cleanVars();
            default:
                if (!isset($this->vars[$name])) {
					throw new UndefinedVariableException($name);
                }

				return $this->vars[$name]->get();
		}
    }

    /**
     * Magic function to work with properties as class variables (set them)
     *
     * @param string $name Var name
     * @param mixed $value New value
     */
    public function __set(string $name, mixed $value): void
    {
        $this->vars[$name]->set($value);
    }

    /**
     * Returns properties as key-value array
     *
     * @return array
     */
    public function toArray(): array
    {
        $ret = array();
        foreach (array_keys($this->vars) as $name) {
            if ($this->vars[$name]->not_loaded) {
                continue;
            }

            if (is_object($this->vars[$name]->value)) {
                $ret[$name] = serialize($this->vars[$name]->value);
            } else {
                $ret[$name] = $this->vars[$name]->value;
            }
        }
        return $ret;
    }

	/**
	 * Returns array of vars or only one var (if name specified) with selected info field
	 *
	 * @param string|null $key Var name
	 * @param string|null $info Var info to get
	 * @param mixed $default Default response
	 *
	 * @return mixed
	 *
	 * @throws UndefinedVariableException
	 */
    public function getVarInfo(?string $key = null, ?string $info = null, mixed $default = null): mixed
    {
		if ($key === null) {
			return $this->vars;
		}

		if ($info === null) {
			if (isset($this->vars[$key])) {
				return $this->vars[$key];
			}

			throw new UndefinedVariableException($key);
		}

		return $this->vars[$key]->$info ?? $default;
	}

    /**
     * returns all variables for the object
     *
     * @access public
     * @return array associative array of key->value pairs
     */
    public function &getVars(): array
    {
        return $this->vars;
    }

    /**
     * Assign values to multiple variables in a batch
     *
     * @access public
     * @param array $var_arr associative array of values to assign
     * @param bool $not_gpc
     */
    public function setVars(array $var_arr, bool $not_gpc = false): void
    {
        foreach ($var_arr as $key => $value) {
            $this->setVar($key, $value, ['not_gpc' => $not_gpc]);
        }
    }

	/**
	 * Sets var value
	 *
	 * @param string $name Var name
	 * @param mixed $value New value
	 * @param bool|array|null $options Options to apply when settings values
	 */
    public function setVar(string $name, mixed $value, bool|array|null $options = null): void
    {
        if ($options !== null) {
            if (is_bool($options)) {
                $this->setVarInfo($name, 'not_gpc', $options);
            } elseif (is_array($options)) {
                foreach ($options as $k2 => $v2) {
                    $this->setVarInfo($name, $k2, $v2);
                }
            }
        }
        $this->__set($name, $value);
    }

	/**
	 * Sets var info
	 *
	 * @param string|string[]|null $key Var name
	 * @param string $info Var option
	 * @param mixed $value Options value
	 */
    public function setVarInfo(string|array|null $key, string $info, mixed $value): void
    {
        if ($key === null) {
            $key = array_keys($this->vars);
        }

        if (is_array($key)) {
            foreach ($key as $k) {
                $this->setVarInfo($k, $info, $value);
            }
            return;
        }

        if (!isset($this->vars[$key])) {
			ServiceHelper::getLogger()?->warning(
				sprintf("Variable %s::\$%s not found", get_class($this), $key)
			);

            return;
        }

        $this->vars[$key][$info] = $value;
		if ($info === 'changed') {
			$this->changed += $value ? 1 : -1;
		}
    }

    /**
     * Return array of properties names
     *
     * @return array
     */
    public function getVarNames(): array
    {
        return array_keys($this->vars);
    }

    /**
     * Sets field as required
     *
     * @param string $key Var name
     * @param bool $is_required Is required?
     */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->setVarInfo()')]
    public function doSetFieldAsRequired(string $key, bool $is_required = true): void
    {
        $this->setVarInfo($key, 'required', $is_required);
    }

    /**
     * Returns cleaned vars array
     *
     * @return array
     */
	#[Deprecated(reason: 'This shortcut will be removed', replacement: '$this->toArray()')]
    public function cleanVars(): array
    {
        return $this->toArray();
    }
}
