<?php

declare(strict_types=1);

namespace Imponeer\Properties;

use Imponeer\Properties\DeprecatedTypes\CurrencyType;
use Imponeer\Properties\DeprecatedTypes\EmailType;
use Imponeer\Properties\DeprecatedTypes\FileType;
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
use Imponeer\Properties\Exceptions\SpecifiedDataTypeNotFound;
use Imponeer\Properties\Types\ArrayType;
use Imponeer\Properties\Types\BooleanType;
use Imponeer\Properties\Types\DateTimeType;
use Imponeer\Properties\Types\FloatType;
use Imponeer\Properties\Types\IntegerType;
use Imponeer\Properties\Types\ListType;
use Imponeer\Properties\Types\ObjectType;
use Imponeer\Properties\Types\OtherType;
use Imponeer\Properties\Types\StringType;

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
     * @var AbstractType[string]
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
     * @param array $values Assoc arary with keys and values to assign
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
     * @param    string $varname Var name
     * @param    bool $displayOnForm Display on form
     * @param    string $default Default value
     *
     * @deprecated
     */
    public function initCommonVar(string $varname, bool $displayOnForm = true, string $default = 'notdefined'): void
    {
        trigger_error('$this->initCommonVar() will be removed in the future!', E_USER_DEPRECATED);
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
        $this->hideFieldFromSingleView($varname);
    }

    /**
     * Initialize var (property) for the object
     *
     * @param string $key Var name
     * @param int|string $dataType Var data type (use constants DTYPE_* for specifing it!)
     * @param mixed $defaultValue Default value
     * @param bool $required Is Required?
     * @param array|null $otherCfg /null $otherCfg  If there is, an assoc array with other configuration for var
     */
    protected function initVar(
        string $key,
        int|string $dataType,
        mixed $defaultValue = null,
        bool $required = false,
        array|null $otherCfg = null
    ): void {
        if (is_int($dataType)) {
            $types = static::getPossibleVarTypes();
            if (!isset($types[$dataType])) {
                throw new SpecifiedDataTypeNotFound();
            }
            $class = $types[$dataType];
        } elseif (stripos($dataType, 'DEP_') === 0) {
            $class = "\\Imponeer\\Properties\\DeprecatedTypes\\" . implode(
                '',
                array_map(
                    'ucfirst',
                    array_map(
                        'strtolower',
                        explode(
                            '_',
                            substr($dataType, 4)
                        )
                    )
                )
            ) . 'Type';
        } elseif (!class_exists($dataType)) {
            $class = "\\Imponeer\\Properties\\Types\\" . implode(
                '',
                array_map(
                    'ucfirst',
                    array_map(
                        'strtolower',
                        explode('_', $dataType)
                    )
                )
            ) . 'Type';
        }

        $this->vars[$key] = new $class($this, $defaultValue, $required, $otherCfg);
    }

    /**
     * Gets class map with possible data types
     *
     * @return array
     */
    protected static function getPossibleVarTypes(): array
    {
        return [
            PropertiesInterface::DTYPE_DEP_CURRENCY => CurrencyType::class,
            PropertiesInterface::DTYPE_DEP_EMAIL => EmailType::class,
            PropertiesInterface::DTYPE_DEP_FILE => FileType::class,
            PropertiesInterface::DTYPE_DEP_FORM_SECTION => FormSectionType::class,
            PropertiesInterface::DTYPE_DEP_FORM_SECTION_CLOSE => FormSectionCloseType::class,
            PropertiesInterface::DTYPE_DEP_IMAGE => ImageType::class,
            PropertiesInterface::DTYPE_DEP_MTIME => MtimeType::class,
            PropertiesInterface::DTYPE_DEP_SOURCE => SourceType::class,
            PropertiesInterface::DTYPE_DEP_STIME => StimeType::class,
            PropertiesInterface::DTYPE_DEP_TIME_ONLY => TimeOnlyType::class,
            PropertiesInterface::DTYPE_DEP_TXTBOX => TxtboxType::class,
            PropertiesInterface::DTYPE_DEP_URL => UrlType::class,
            PropertiesInterface::DTYPE_DEP_URLLINK => UrllinkType::class,
            PropertiesInterface::DTYPE_ARRAY => ArrayType::class,
            PropertiesInterface::DTYPE_BOOLEAN => BooleanType::class,
            PropertiesInterface::DTYPE_DATETIME => DateTimeType::class,
            PropertiesInterface::DTYPE_FILE => \Imponeer\Properties\Types\FileType::class,
            PropertiesInterface::DTYPE_FLOAT => FloatType::class,
            PropertiesInterface::DTYPE_INTEGER => IntegerType::class,
            PropertiesInterface::DTYPE_LIST => ListType::class,
            PropertiesInterface::DTYPE_OBJECT => ObjectType::class,
            PropertiesInterface::DTYPE_OTHER => OtherType::class,
            PropertiesInterface::DTYPE_STRING => StringType::class
        ];
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
        $ret = array();
        foreach ($this->vars as $key => $var) {
            $ret[$key] = $var->defaultValue;
        }
        return $ret;
    }

    /**
     * Returns the values of the specified variables
     *
     * @param mixed $keys An array containing the names of the keys to retrieve, or null to get all of them
     * @param string $format Format to use (see getVar)
     * @param int $maxDepth Maximum level of recursion to use if some vars are objects themselves
     * @return array associative array of key->value pairs
     */
    public function getValues(mixed $keys = null, string $format = 's', int $maxDepth = 1): array
    {
        if (!isset($keys)) {
            $keys = array_keys($this->vars);
        }
        $vars = array();
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
     * @param string $format format to use for the output
     * @return mixed formatted value of the variable
     */
    public function getVar(string $name, string $format = 's'): mixed
    {
        switch (strtolower($format)) {
            case 's':
            case 'show':
            case 'p':
            case 'preview':
                $ret = $this->getVarForDisplay($name);
                break;
            case 'e':
            case 'edit':
                $ret = $this->getVarForEdit($name);
                break;
            case 'f':
            case 'formpreview':
                $ret = $this->getVarForForm($name);
                break;
            case 'n':
            case 'none':
            default:
                $ret = $this->__get($name);
        }
        return $ret;
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
     */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case '_vars':
            case 'vars':
                if (isset($this->vars[$name])) {
                    return $this->vars[$name]->get();
                } else {
                    trigger_error('Use $this->getVars() of $this->' . $name . ' instead!', E_USER_DEPRECATED);
                    return $this->vars;
                }
            case 'cleanVars':
                trigger_error('Use $this->toArray() of $this->' . $name . ' instead!', E_USER_DEPRECATED);
                return $this->toArray();
            default:
                if (!isset($this->vars[$name])) {
                    $callers = debug_backtrace();
                    trigger_error(
                        sprintf(
                            '%s undefined for %s (in line %d)',
                            $name,
                            $callers[0]['file'],
                            $callers[0]['line']
                        ),
                        E_USER_WARNING
                    );
                    return null;
                } else {
                    return $this->vars[$name]->get();
                }
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
     * @param string $key Var name
     * @param string $info Var info to get
     * @param mixed $default Default response
     *
     * @return mixed
     */
    public function getVarInfo(string $key = null, string $info = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->vars;
        } elseif ($info === null) {
            if (isset($this->vars[$key])) {
                return $this->vars[$key];
            } else {
                $callers = debug_backtrace();
                trigger_error(
                    sprintf(
                        '%s in %s on line %d doesn\'t exist',
                        $key,
                        $callers[0]['file'],
                        $callers[0]['line']
                    ),
                    E_USER_ERROR
                );
                return $default;
            }
        } elseif (isset($this->vars[$key]->$info)) {
            return $this->vars[$key]->$info;
        } else {
            return $default;
        }
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
            $this->setVar($key, $value, $not_gpc);
        }
    }

    /**
     * Sets var value
     *
     * @param string $name Var name
     * @param mixed $value New value
     * @param array $options Options to apply when settings values
     */
    public function setVar(string $name, mixed $value, array $options = null): void
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
     * @param string $key Var name
     * @param string $info Var option
     * @param mixed $value Options value
     */
    public function setVarInfo(string $key, string $info, mixed $value): void
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
            trigger_error('Variable ' . get_class($this) . '::$' . $key . ' not found', E_USER_WARNING);
            return;
        }

        $this->vars[$key][$info] = $value;
        switch ($info) {
            case 'changed':
                if ($value) {
                    $this->changed++;
                } else {
                    $this->changed--;
                }
                break;
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
     *
     * @deprecated
     */
    public function doSetFieldAsRequired(string $key, bool $is_required = true): void
    {
        trigger_error('Use not $this->doSetFieldAsRequired() but $this->setVarInfo() instead!', E_USER_DEPRECATED);
        $this->setVarInfo($key, 'required', $is_required);
    }

    /**
     * Returns cleaned vars array
     *
     * @return array
     *
     * @deprecated
     */
    public function cleanVars(): array
    {
        trigger_error('Use not $this->cleanVars() but $this->toArray() instead!', E_USER_DEPRECATED);
        return $this->toArray();
    }

    /**
     * Creates instance from name
     *
     * @param string $namespace Namespace where class to be found
     * @param string $name Name from what instance must be created
     * @param string $suffix Sufix for class name
     *
     * @return object
     *
     * @throws SpecifiedDataTypeNotFound
     */
    private function createInstanceFromName(string $namespace, string $name, string $suffix = ''): object
    {
        $class = $namespace . implode(
            '',
            array_map(
                'ucfirst',
                array_map(
                    'strtolower',
                    explode('_', $name)
                )
            )
        ) . $suffix;
        if (class_exists($class, true)) {
            return new $class();
        } else {
            throw new SpecifiedDataTypeNotFound();
        }
    }
}
