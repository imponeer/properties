<?php

namespace Imponeer\Properties;


interface PropertiesInterface {
	/**
	 * Specifies property that a property stores a string
	 */
	const DTYPE_STRING = 2; // XOBJ_TXTBOX

	/**
	 * Specifies property that a property stores a integer
	 */
	const DTYPE_INTEGER = 3; // XOBJ_INT

	/**
	 * Specifies property that a property stores a float number
	 */
	const DTYPE_FLOAT = 201; // XOBJ_FLOAT

	/**
	 * Specifies property that a property stores a boolean
	 */
	const DTYPE_BOOLEAN = 105;

	/**
	 * Specifies property that a property stores a file
	 */
	const DTYPE_FILE = 104; //

	/**
	 * Specifies property that a property stores a date or/and time
	 */
	const DTYPE_DATETIME = 11; // XOBJ_LTIME

	/**
	 * Specifies property that a property stores an array
	 */
	const DTYPE_ARRAY = 6; // XOBJ_ARRAY
	/**
	 * Specifies property that a property stores a list
	 */
	const DTYPE_LIST = 101; // XOBJ_SIMPLE_ARRAY

	/**
	 * Specifies property that a property stores a object
	 */
	const DTYPE_OBJECT = 12;

	/**
	 * Specifies property that a property stores a unknown format data
	 */
	const DTYPE_OTHER = 7; // XOBJ_OTHER

	/**
	 * Specifies property that a property stores a file (old format)
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_FILE = 204; //XOBJ_FILE

	/**
	 * Specifies property that a property stores a long string)
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_TXTBOX = 1; // XOBJ_TXTBOX

	/**
	 * Specifies property that a property stores a url string
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_URL = 4; // XOBJ_URL

	/**
	 * Specifies property that a property stores a email address
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_EMAIL = 5; // XOBJ_EMAIL

	/**
	 * Specifies property that a property stores a source code
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_SOURCE = 8; // XOBJ_SOURCE

	/**
	 * Specifies property that a property stores a short time
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_STIME = 9; // XOBJ_STIME

	/**
	 * Specifies property that a property stores a middle time
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_MTIME = 10; // XOBJ_MTIME

	/**
	 * Specifies property that a property stores a currency
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_CURRENCY = 200; // XOBJ_CURRENCY

	/**
	 * Specifies property that a property stores a time only data
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_TIME_ONLY = 202; // XOBJ_TIME_ONLY

	/**
	 * Specifies property that a property stores a urllink
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_URLLINK = 203; // XOBJ_URLLINK

	/**
	 * Specifies property that a property stores a image
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_IMAGE = 205; // XOBJ_IMAGE

	/**
	 * Specifies property that a property stores a form section opening
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_FORM_SECTION = 210; // XOBJ_FORM_SECTION

	/**
	 * Specifies property that a property stores a form section closing
	 *
	 * @deprecated
	 */
	const DTYPE_DEP_FORM_SECTION_CLOSE = 211; // XOBJ_FORM_SECTION_CLOSE

	/**
	 * Validation rule for emails
	 */
	const VALIDATION_RULE_EMAIL = '/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i';

	/**
	 * Validation rule for links
	 */
	const VALIDATION_RULE_LINKS = '#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i';

}