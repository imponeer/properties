<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/21/2017
 * Time: 6:33 PM
 */

namespace IPFLibraries\Properties;

use MyCLabs\Enum\Enum;

/**
 * Configuration options for property
 *
 * @package IPFLibraries\Properties
 */
class ConfigOption extends Enum
{
	/**
	 * Specifies allowed mimetypes for the var (only suported for DTYPE_FILE)
	 */
	const ALLOWED_MIMETYPES = 'allowedMimeTypes';

	/**
	 * Specifies max filesize for the var (only suported for DTYPE_FILE)
	 */
	const MAX_FILESIZE = 'maxFileSize';

	/**
	 * Specifies max width of image for the var (only suported for DTYPE_FILE)
	 */
	const MAX_WIDTH = 'maxWidth';

	/**
	 * Specifies max height for the var (only suported for DTYPE_FILE)
	 */
	const MAX_HEIGHT = 'maxHeight';

	/**
	 * Specifies prefix for the var (only suported for DTYPE_FILE, DTYPE_STRING)
	 */
	const PREFIX = 'prefix';

	/**
	 * Specifies saving path for the var (only suported for DTYPE_FILE)
	 */
	const PATH = 'path';

	/**
	 * Specifies filename generator function for the var (only suported for DTYPE_FILE)
	 */
	const FILENAME_FUNCTION = 'filenameGenerator';

	/**
	 * Specifies list with options that can be used for the var
	 */
	const POSSIBLE_OPTIONS = 'possibleOptions';

	/**
	 * Specifies if this var is locked from changing?
	 */
	const LOCKED = 'locked';

	/**
	 * Specifies if this var is hidden from user
	 */
	const HIDE = 'hide';

	/**
	 * Specifies how var should be rendered
	 */
	const RENDER_TYPE = 'renderType';

	/**
	 * Specifies separator for saving list items for the var (only suported for DTYPE_LIST)
	 */
	const SEPARATOR = 'separator';

	/**
	 * Specifies max text length for the var (only suported for DTYPE_STRING)
	 */
	const MAX_LENGTH = 'maxLength';

	/**
	 * Specifies validation rule (REGEXP)
	 */
	const VALIDATE_RULE = 'validateRule';

	/**
	 * Specifies source formating options (only usable for DTYPE_STRING)
	 */
	const SOURCE_FORMATING = 'sourceFormating';

	/**
	 * Specifies outputing formating
	 */
	const FORMAT = 'format';

	/**
	 * Is autoforating for this var disabled?
	 */
	const AF_DISABLED = 'autoFormatingDisabled';

	/**
	 * Not GPC?
	 */
	const NOT_GPC = 'not_gpc';

	/**
	 * Is var changed?
	 */
	const CHANGED = 'changed';

	/**
	 * Value of var
	 */
	const VALUE = 'value';

	/**
	 * Var data type
	 */
	const TYPE = 'data_type';

	/**
	 * Is var required?
	 */
	const REQUIRED = 'required';

	/**
	 * Data handler
	 */
	const DATA_HANDLER = 'data_handler';

	/**
	 * Deprecached data type
	 */
	const DEP_DATA_TYPE = 'depDataType';

	/**
	 * Form caption for this var
	 */
	const FORM_CAPTION = ConfigOption::FORM_CAPTION;

	/**
	 * Form description for this var
	 */
	const FORM_DESC = 'form_dsc';

	/**
	 * Default value of this var
	 */
	const DEFAULT_VALUE = 'default_value';

	/**
	 * Is var not loaded?
	 */
	const NOTLOADED = 'not_loaded';
}