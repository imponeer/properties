<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/20/2017
 * Time: 12:31 AM
 */

namespace IPFLibraries\Properties;

/**
 * Interface for defining common vars
 *
 * @package IPFLibraries\Properties
 */
interface CommonPropertyInterface
{

	/**
	 * Parse value
	 *
	 * @param mixed $default	Default value
	 *
	 * @return mixed
	 */
	public function parseValue($default);

	/**
	 * Gets datatype
	 *
	 * @return string|int
	 */
	public function getDataType();

	/**
	 * Is required?
	 *
	 * @return bool
	 */
	public function isRequired();

	/**
	 * Gets other config data
	 *
	 * @return array|null
	 */
	public function getOtherConfig();

	/**
	 * Gets form control options
	 *
	 * @return array|null
	 */
	public function getControl();
}