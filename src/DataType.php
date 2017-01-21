<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/21/2017
 * Time: 6:02 PM
 */

namespace IPFLibraries\Properties;

use MyCLabs\Enum\Enum;

/**
 * Defines possible data types
 *
 * @package IPFLibraries\Properties
 */
class DataType extends Enum
{

	/**
	 * Specifies property that a property stores a string
	 */
	const STRING = 2; // XOBJ_TXTBOX

	/**
	 * Specifies property that a property stores a integer
	 */
	const INTEGER = 3; // XOBJ_INT

	/**
	 * Specifies property that a property stores a float number
	 */
	const FLOAT = 201; // XOBJ_FLOAT

	/**
	 * Specifies property that a property stores a boolean
	 */
	const BOOLEAN = 105;

	/**
	 * Specifies property that a property stores a file
	 */
	const FILE = 104; //

	/**
	 * Specifies property that a property stores a date or/and time
	 */
	const DATETIME = 11; // XOBJ_LTIME

	/**
	 * Specifies property that a property stores an array
	 */

	const ARRAY = 6; // XOBJ_ARRAY
	/**
	 * Specifies property that a property stores a list
	 */
	const LIST = 101; // XOBJ_SIMPLE_ARRAY

	/**
	 * Specifies property that a property stores a object
	 */
	const OBJECT = 12;

	/**
	 * Specifies property that a property stores a unknown format data
	 *
	 * @deprecated
	 */
	const DEP_OTHER = 7; // XOBJ_OTHER

	/**
	 * Specifies property that a property stores a file (old format)
	 *
	 * @deprecated
	 */
	const DEP_FILE = 204; //XOBJ_FILE

	/**
	 * Specifies property that a property stores a long string)
	 *
	 * @deprecated
	 */
	const DEP_TXTBOX = 1; // XOBJ_TXTBOX

	/**
	 * Specifies property that a property stores a url string
	 *
	 * @deprecated
	 */
	const DEP_URL = 4; // XOBJ_URL

	/**
	 * Specifies property that a property stores a email address
	 *
	 * @deprecated
	 */
	const DEP_EMAIL = 5; // XOBJ_EMAIL

	/**
	 * Specifies property that a property stores a source code
	 *
	 * @deprecated
	 */
	const DEP_SOURCE = 8; // XOBJ_SOURCE

	/**
	 * Specifies property that a property stores a short time
	 *
	 * @deprecated
	 */
	const DEP_STIME = 9; // XOBJ_STIME

	/**
	 * Specifies property that a property stores a middle time
	 *
	 * @deprecated
	 */
	const DEP_MTIME = 10; // XOBJ_MTIME

	/**
	 * Specifies property that a property stores a currency
	 *
	 * @deprecated
	 */
	const DEP_CURRENCY = 200; // XOBJ_CURRENCY

	/**
	 * Specifies property that a property stores a time only data
	 *
	 * @deprecated
	 */
	const DEP_TIME_ONLY = 202; // XOBJ_TIME_ONLY

	/**
	 * Specifies property that a property stores a urllink
	 *
	 * @deprecated
	 */
	const DEP_URLLINK = 203; // XOBJ_URLLINK

	/**
	 * Specifies property that a property stores a image
	 *
	 * @deprecated
	 */
	const DEP_IMAGE = 205; // XOBJ_IMAGE

	/**
	 * Specifies property that a property stores a form section opening
	 *
	 * @deprecated
	 */
	const DEP_FORM_SECTION = 210; // XOBJ_FORM_SECTION

	/**
	 * Specifies property that a property stores a form section closing
	 *
	 * @deprecated
	 */
	const DEP_FORM_SECTION_CLOSE = 211; // XOBJ_FORM_SECTION_CLOSE

}