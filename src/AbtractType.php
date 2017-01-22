<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/21/2017
 * Time: 9:57 PM
 */

namespace IPFLibraries\Properties;


use IPFLibraries\Properties\Exceptions\PropertyIsLockedException;
use IPFLibraries\Properties\Exceptions\ValueIsNotInPossibleValuesListException;

abstract class AbstractType
{
	/**
	 * Is locked from modifications?
	 *
	 * @var bool
	 */
	public $locked = false;
	/**
	 * Possible options
	 *
	 * @var array
	 */
	public $possibleOptions = [];
	/**
	 * Is changed?
	 *
	 * @var bool
	 */
	public $changed = false;
	/**
	 * Not loaded?
	 *
	 * @var bool
	 */
	public $not_loaded = false;
	/**
	 * Default value
	 *
	 * @var mixed
	 */
	public $defaultValue = null;
	/**
	 * Is required?
	 *
	 * @var bool
	 */
	public $required = false;
	/**
	 * Data handler (used for linking data with database)
	 *
	 * @var string|null
	 */
	public $data_handler;
	/**
	 * Hide from user?
	 *
	 * @var bool
	 */
	public $hide = false;
	/**
	 * Current value
	 *
	 * @var mixed
	 */
	protected $value = null;
	/**
	 * Parent
	 *
	 * @var object
	 */
	protected $parent;

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
	 * Returns if current type is one of deprecated types
	 *
	 * @return bool
	 */
	public function isDeprecatedType()
	{
		$namespace = '\\IPFLibraries\\Properties\\DeprecatedTypes\\';
		$l = strlen($namespace);
		if (strlen(static::class) < $l) {
			return false;
		}
		return substr(static::class, 0, $l) == $namespace;
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

	/**
	 * Set value
	 *
	 * @param $value Value to set
	 */
	public function set($value)
	{
		if ($this->locked) {
			throw new PropertyIsLockedException();
		}
		if (!empty($this->possibleOptions) && !in_array($value, $this->possibleOptions)) {
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

}