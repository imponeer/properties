<?php

namespace IPFLibraries\Properties;

/**
 * Contains methods for dealing with object properties
 *
 * @copyright   The ImpressCMS Project http://www.impresscms.org/
 * @license        MIT https://opensource.org/licenses/MIT
 * @author        mekdrop@impresscms.org
 */
trait PropertiesSupport
{

	/**
	 * Vars configuration
	 *
	 * @var array
	 */
	protected $_vars = array();

	/**
	 * Changed vars count
	 *
	 * @var int
	 */
	protected $_changed = 0;

	/**
	 * Assigns values from array to vars
	 *
	 * @param array $values Assoc arary with keys and values to assign
	 */
	public function assignVars($values)
	{
		foreach ($this->_vars as $key => $var) {
			$value = (!isset($values[$key])) ? null : $values[$key];
			$this->_vars[$key][ConfigOption::VALUE] = $this->cleanVar($key, $this->_vars[$key][ConfigOption::TYPE], $value);
		}
	}

	/**
	 * Cleans value for var
	 *
	 * @param string $key Var name
	 * @param string $type Var type
	 * @param string $value new value
	 *
	 * @return mixed
	 */
	protected function cleanVar($key, $type, $value)
	{
		switch ($type) {
			case DataType::OBJECT:
				if ($value === null || is_object($value)) {
					return $value;
				}
				if (is_string($value)) {
					if (substr($value, 0, 1) == '{') {
						return json_decode($value, false);
					} elseif (substr($value, 0, 2) == 'O:') {
						return unserialize($value);
					} elseif (class_exists($value, true)) {
						return new $value();
					} else {
						return null;
					}
				}
				return (object)$value;
			case DataType::BOOLEAN:
				if (is_bool($value)) {
					return $value;
				}
				if (!is_string($value)) {
					return (bool)intval($value);
				}
				$value = strtolower($value);
				return ($value == 'yes') || ($value == 'true');
			case DataType::LIST:
				if ((array)($value) === $value) {
					return $value;
				}
				if (empty($value)) {
					return array();
				}
				if (is_string($value)) {
					return explode($this->_vars[$key][ConfigOption::SEPARATOR], strval($value));
				} else {
					return array($value);
				}
			case DataType::FLOAT:
				return (float)$value;
			case DataType::INTEGER:
				return (int)$value;
			case DataType::ARRAY:
				if (((array)$value) === $value) {
					return $value;
				}
				if (empty($value)) {
					return array();
				}
				if (is_string($value)) {
					if (in_array(substr($value, 0, 1), array('{', '['))) {
						$ret = json_decode($value, true);
					} elseif (substr($value, 0, 2) == 'a:') {
						$ret = unserialize($value);
					}
					if (isset($ret) && ($ret !== null)) {
						return $ret;
					}
				}
				return (array)$value;
			case DataType::FILE:
				if (isset($_FILES[$key])) {
					$uploader = new icms_file_MediaUploadHandler($this->_vars[$key]['path'], $this->_vars[$key]['allowedMimeTypes'], $this->_vars[$key]['maxFileSize'], $this->_vars[$key]['maxWidth'], $this->_vars[$key]['maxHeight']);
					if ($uploader->fetchMedia($key)) {
						if (!empty($this->_vars[$key][ConfigOption::FILENAME_FUNCTION])) {
							$filename = call_user_func($this->_vars[$key][ConfigOption::FILENAME_FUNCTION], 'post', $uploader->getMediaType(), $uploader->getMediaName());
							if (!empty($this->_vars[$key][ConfigOption::PREFIX])) {
								$filename = $this->_vars[$key][ConfigOption::PREFIX] . $filename;
							}
							$uploader->setTargetFileName($filename);
						} elseif (!empty($this->_vars[$key][ConfigOption::PREFIX])) {
							$uploader->setPrefix($this->_vars[$key][ConfigOption::PREFIX]);
						}
						if ($uploader->upload()) {
							return array(
								'filename' => $uploader->getSavedFileName(),
								'mimetype' => $uploader->getMediaType(),
							);
						}
						return null;
					}
				} elseif (is_string($value)) {
					if (file_exists($value)) {
						return array(
							'filename' => $value,
							'mimetype' => $this->getFileMimeType($value),
						);
					}
					$uploader = new icms_file_MediaUploadHandler($this->_vars[$key][ConfigOption::PATH], $this->_vars[$key][ConfigOption::ALLOWED_MIMETYPES], $this->_vars[$key][ConfigOption::MAX_FILESIZE], $this->_vars[$key][ConfigOption::MAX_WIDTH], $this->_vars[$key][ConfigOption::MAX_HEIGHT]);
					if ($uploader->fetchFromURL($value)) {
						if (!empty($this->_vars[$key][ConfigOption::FILENAME_FUNCTION])) {
							$filename = call_user_func($this->_vars[$key][ConfigOption::FILENAME_FUNCTION], 'post', $uploader->getMediaType(), $uploader->getMediaName());
							if (!empty($this->_vars[$key][ConfigOption::PREFIX])) {
								$filename = $this->_vars[$key][ConfigOption::PREFIX] . $filename;
							}
							$uploader->setTargetFileName($filename);
						} elseif (!empty($this->_vars[$key][ConfigOption::PREFIX])) {
							$uploader->setPrefix($this->_vars[$key][ConfigOption::PREFIX]);
						}
						if ($uploader->upload()) {
							return array(
								'filename' => $uploader->getSavedFileName(),
								'mimetype' => $uploader->getMediaType(),
							);
						}
						trigger_error(strip_tags($uploader->getErrors()), E_USER_NOTICE);
						return null;
					}
					return null;
				} elseif (isset($value['filename']) || isset($value['mimetype'])) {
					if (!isset($value['filename']) || !isset($value['mimetype'])) {
						return null;
					}
					return $value;
				}
				return null;
			case DataType::DATETIME:
				if (is_int($value)) {
					return $value;
				}
				if ($value === null) {
					return 0;
				}
				if (is_numeric($value)) {
					return intval($value);
				}
				if (!is_string($value)) {
					return 0;
				}
				if (preg_match('/(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)/ui', $value, $ret)) {
					$time = gmmktime($ret[4], $ret[5], $ret[6], $ret[2], $ret[3], $ret[1]);
				} else {
					$time = (int)strtotime($value);
				}
				return ($time < 0) ? 0 : $time;
			case DataType::STRING:
			default:
				if (!is_string($value)) {
					$value = strval($value);
				}
				if (isset($this->_vars[$key][ConfigOption::NOT_GPC]) && !$this->_vars[$key][ConfigOption::NOT_GPC] && get_magic_quotes_gpc()) {
					$value = stripslashes($value);
				}
				if (!empty($this->_vars[$key][ConfigOption::VALUE]) && isset($this->_vars[$key][ConfigOption::VALIDATE_RULE]) && !empty($this->_vars[$key][ConfigOption::VALIDATE_RULE])) {
					if (!preg_match($this->_vars[$key][ConfigOption::VALIDATE_RULE], $value)) {
						trigger_error(sprintf('Bad format for %s var (%s)', $key, $value), E_USER_ERROR);
					} elseif (!isset($this->_vars[$key][ConfigOption::SOURCE_FORMATING]) || empty($this->_vars[$key][ConfigOption::SOURCE_FORMATING])) {
						$value = icms_core_DataFilter::censorString($value);
					}
				}
				if (isset($this->_vars[$key][ConfigOption::MAX_LENGTH]) && ($this->_vars[$key][ConfigOption::MAX_LENGTH] > 0) && (mb_strlen($value) > $this->_vars[$key][ConfigOption::MAX_LENGTH])) {
					trigger_error(sprintf(_XOBJ_ERR_SHORTERTHAN, $key, (int)$this->_vars[$key][ConfigOption::MAX_LENGTH]), E_USER_WARNING);
					$value = mb_substr($value, 0, $this->_vars[$key][ConfigOption::MAX_LENGTH]);
				}
				return $value;
		}
	}

	/**
	 * Gets mymetype from filename
	 *
	 * @param string $filename Filename
	 *
	 * @return string
	 */
	private function getFileMimeType($filename)
	{
		if (function_exists('finfo_open')) {
			$info = finfo_open(FILEINFO_MIME_TYPE);
			$rez = finfo_file($info, $filename);
			finfo_close($info);
			return $rez;
		}
		if (function_exists('mime_content_type')) {
			return mime_content_type($filename);
		}
		return 'unknown/unknown';
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
	public function initCommonVar($varname, $displayOnForm = true, $default = 'notdefined')
	{
		trigger_error('$this->initCommonVar() will be removed in the future!', E_USER_DEPRECATED);
		switch ($varname) {
			case 'docxode':
				trigger_error('You should use doxcode in code. Not docxode.', E_USER_WARNING);
				$varname = 'doxcode';
				break;
		}
		$class = "\\IPFLibraries\\Properties\\CommonProperties\\" . implode('',
				array_map('ucfirst', explode('_', $varname))
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
	 * @param int $dataType Var data type (use constants DTYPE_* for specifing it!)
	 * @param mixed $defaultValue Default value
	 * @param bool $required Is Required?
	 * @param array /null $otherCfg  If there is, an assoc array with other configuration for var
	 */
	protected function initVar($key, $dataType, $defaultValue = null, $required = false, $otherCfg = null)
	{
		if ($otherCfg !== null) {
			$this->_vars[$key] = $otherCfg;
			if (isset($this->_vars[$key][ConfigOption::POSSIBLE_OPTIONS]) && is_string($this->_vars[$key][ConfigOption::POSSIBLE_OPTIONS])) {
				$this->_vars[$key][ConfigOption::POSSIBLE_OPTIONS] = explode('|', $this->_vars[$key][ConfigOption::POSSIBLE_OPTIONS]);
			}
		} else {
			$this->_vars[$key] = array();
		}
		switch ($dataType) {
			case DataType::FILE:
				if (!isset($this->_vars[$key][ConfigOption::ALLOWED_MIMETYPES])) {
					$this->_vars[$key][ConfigOption::ALLOWED_MIMETYPES] = 0;
				} elseif (is_string($this->_vars[$key][ConfigOption::ALLOWED_MIMETYPES])) {
					$this->_vars[$key][ConfigOption::ALLOWED_MIMETYPES] = array($this->_vars[$key][ConfigOption::ALLOWED_MIMETYPES]);
				}
				if (!isset($this->_vars[$key][ConfigOption::MAX_FILESIZE])) {
					$this->_vars[$key][ConfigOption::MAX_FILESIZE] = 1000000;
				} elseif (!is_int($this->_vars[$key][ConfigOption::MAX_FILESIZE])) {
					$this->_vars[$key][ConfigOption::MAX_FILESIZE] = intval($this->_vars[$key][ConfigOption::MAX_FILESIZE]);
				}
				if (!isset($this->_vars[$key][ConfigOption::MAX_WIDTH])) {
					$this->_vars[$key][ConfigOption::MAX_WIDTH] = 500;
				} elseif (!is_int($this->_vars[$key][ConfigOption::MAX_WIDTH])) {
					$this->_vars[$key][ConfigOption::MAX_WIDTH] = intval($this->_vars[$key][ConfigOption::MAX_WIDTH]);
				}
				if (!isset($this->_vars[$key][ConfigOption::MAX_HEIGHT])) {
					$this->_vars[$key][ConfigOption::MAX_HEIGHT] = 500;
				} elseif (!is_int($this->_vars[$key][ConfigOption::MAX_HEIGHT])) {
					$this->_vars[$key][ConfigOption::MAX_HEIGHT] = intval($this->_vars[$key][ConfigOption::MAX_HEIGHT]);
				}
				if (!isset($this->_vars[$key][ConfigOption::PATH]) || empty($this->_vars[$key][ConfigOption::PATH])) {
					$this->_vars[$key][ConfigOption::PATH] = ICMS_UPLOAD_PATH;
				}
				if (!isset($this->_vars[$key][ConfigOption::PREFIX])) {
					$this->_vars[$key][ConfigOption::PREFIX] = str_replace(array('icms_ipf_', 'mod_'), '', get_class($this));
				}
				if (!isset($this->_vars[$key][ConfigOption::FILENAME_FUNCTION])) {
					$this->_vars[$key][ConfigOption::FILENAME_FUNCTION] = null;
				}
				break;
			case DataType::LIST:
				if (!isset($this->_vars[$key][ConfigOption::SEPARATOR])) {
					$this->_vars[$key][ConfigOption::SEPARATOR] = ';';
				}
				break;
			case DataType::DEP_CURRENCY:
				trigger_error('Use not DEP_CURRENCY but DTYPE_FLOAT with ConfigOption::FORMAT "%01.2f" instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::FORMAT] = '%01.2f';
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::FLOAT;
				break;
			case DataType::DEP_MTIME:
				trigger_error('Use not DEP_MTIME but DTYPE_DATETIME with ConfigOption::FORMAT _MEDIUMDATESTRING instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::FORMAT] = _MEDIUMDATESTRING;
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::DATETIME;
				break;
			case DataType::DEP_STIME:
				trigger_error('Use not DEP_STIME but DTYPE_DATETIME with ConfigOption::FORMAT _SHORTDATESTRING instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::FORMAT] = _SHORTDATESTRING;
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::DATETIME;
				break;
			case DataType::DEP_TIME_ONLY:
				trigger_error('Use not DEP_TIME_ONLY but DTYPE_DATETIME with ConfigOption::FORMAT "s:i" instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::FORMAT] = 's:i';
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::DATETIME;
				break;
			case DataType::DEP_FORM_SECTION:
			case DataType::DEP_FORM_SECTION_CLOSE:
				trigger_error('DEP_FORM_SECTION and DEP_FORM_SECTION_CLOSE will be removed!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::OTHER;
				break;
			case DataType::DEP_SOURCE:
				trigger_error('Use not DEP_SOURCE but DTYPE_STRING with specified ConfigOption::SOURCE_FORMATING instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::SOURCE_FORMATING] = 'php';
				$this->_vars[$key][ConfigOption::AF_DISABLED] = true;
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::STRING;
				break;
			case DataType::DEP_URL:
				trigger_error('Use not DEP_URL but DTYPE_STRING with specified ConfigOption::VALIDATE_RULE VALIDATE_RULE_LINKS instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::VALIDATE_RULE] = self::VALIDATE_RULE_LINKS;
				$this->_vars[$key][ConfigOption::AF_DISABLED] = true;
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::STRING;
				break;
			case DataType::DEP_URLLINK:
				trigger_error('Use not DEP_URLLINK but DTYPE_INTEGER with ConfigOption::DATA_HANDLER = "link" instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::VALIDATE_RULE] = self::VALIDATE_RULE_LINKS;
				$this->_vars[$key][ConfigOption::AF_DISABLED] = true;
				$this->_vars[$key][ConfigOption::DATA_HANDLER] = 'link';
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::INTEGER;
				break;
			case DataType::DEP_EMAIL:
				trigger_error('Use not DEP_EMAIL but DTYPE_STRING with specified ConfigOption::VALIDATE_RULE VALIDATE_RULE_EMAIL instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::VALIDATE_RULE] = self::VALIDATE_RULE_EMAIL;
				$this->_vars[$key][ConfigOption::AF_DISABLED] = true;
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::STRING;
				break;
			case DataType::DEP_TXTBOX:
				trigger_error('Use not DEP_TXTBOX but DTYPE_STRING with specified ConfigOption::MAX_LENGTH = 255 instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::MAX_LENGTH] = 255;
				$this->_vars[$key][ConfigOption::AF_DISABLED] = true;
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::STRING;
				break;
			case DataType::DEP_IMAGE:
				trigger_error('Use not DEP_IMAGE but DTYPE_INTEGER with ConfigOption::DATA_HANDLER = "image" instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::ALLOWED_MIMETYPES] = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/svg+xml', 'image/tiff', 'image/vnd.microsoft.icon');
				$this->_vars[$key][ConfigOption::DATA_HANDLER] = 'image';
				$this->_vars[$key][ConfigOption::AF_DISABLED] = true;
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::INTEGER;
			case DataType::DEP_FILE:
				trigger_error('Use not DEP_FILE but DTYPE_INTEGER with ConfigOption::DATA_HANDLER = "file" instead!', E_USER_DEPRECATED);
				$this->_vars[$key][ConfigOption::DATA_HANDLER] = 'file';
				$this->_vars[$key][ConfigOption::AF_DISABLED] = true;
				$this->_vars[$key][ConfigOption::DEP_DATA_TYPE] = $dataType;
				$dataType = DataType::INTEGER;
				break;
		}
		if (!isset($this->_vars[$key][ConfigOption::LOCKED])) {
			$this->_vars[$key][ConfigOption::LOCKED] = false;
		}
		$this->_vars[$key][ConfigOption::TYPE] = $dataType;
		$this->_vars[$key][ConfigOption::DEFAULT_VALUE] = $defaultValue; //$this->cleanVar($key, $dataType, $defaultValue);
		$this->_vars[$key][ConfigOption::REQUIRED] = $required;
		$this->_vars[$key][ConfigOption::VALUE] = $defaultValue;
	}

	/**
	 * Checks if var exists
	 *
	 * @param string $name Var name
	 *
	 * @return bool
	 */
	public function __isset($name)
	{
		return isset($this->_vars[$name]);
	}

	/**
	 * assign a value to a variable
	 *
	 * @access public
	 * @param string $key name of the variable to assign
	 * @param mixed $value value to assign
	 */
	public function assignVar($key, &$value)
	{
		if (isset($value) && isset($this->_vars[$key])) {
			$this->_vars[$key][ConfigOption::VALUE] = $value;
		}
	}

	/**
	 * Gets changes vars
	 *
	 * @return array
	 */
	public function getChangedVars()
	{
		$changed = array();
		foreach ($this->_vars as $key => $format) {
			if (isset($format[ConfigOption::CHANGED]) && $format[ConfigOption::CHANGED]) {
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
	public function isChanged()
	{
		return $this->_changed > 0;
	}

	/**
	 * Gets an array with required but not specified vars
	 *
	 * @return array
	 */
	public function getProblematicVars()
	{
		$names = array();
		foreach ($this->_vars as $key => $format)
			if ($format[ConfigOption::REQUIRED] && ($this->isVarSet($format[ConfigOption::TYPE], $key) === false)) {
				$names[] = $key;
			}
		return $names;
	}

	/**
	 * Checks if var is set
	 *
	 * @param int $type
	 * @param string $key
	 *
	 * @return boolean
	 */
	private function isVarSet($type, $key)
	{
		switch ($type) {
			case DataType::LIST:
			case DataType::ARRAY:
			case DataType::FILE:
				return (isset($this->_vars[$key][ConfigOption::VALUE]['filename']) && !empty($this->_vars[$key][ConfigOption::VALUE]['filename']));
			case DataType::BOOLEAN:
			case DataType::INTEGER:
			case DataType::FLOAT:
				return true;
			case DataType::OBJECT:
				return is_object($this->_vars[$key][ConfigOption::VALUE]);
			case DataType::STRING:
				return strlen($this->_vars[$key][ConfigOption::VALUE]) > 0;
			case DataType::DATETIME:
				return is_int($this->_vars[$key][ConfigOption::VALUE]) && ($this->_vars[$key][ConfigOption::VALUE] > 0);
		}
	}

	/**
	 * Gets default values for all vars
	 *
	 * @return array
	 */
	public function getDefaultVars()
	{
		$ret = array();
		foreach ($this->_vars as $key => $info) {
			$ret[$key] = $info[ConfigOption::DEFAULT_VALUE];
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
	public function getValues($keys = null, $format = 's', $maxDepth = 1)
	{
		if (!isset($keys)) {
			$keys = array_keys($this->_vars);
		}
		$vars = array();
		foreach ($keys as $key) {
			if (isset($this->_vars[$key])) {
				if (is_object($this->_vars[$key][ConfigOption::VALUE]) && ($this->_vars[$key][ConfigOption::VALUE] instanceof PropertiesSupport)) {
					if ($maxDepth) {
						$vars[$key] = $this->_vars[$key]->getValues(null, $format, $maxDepth - 1);
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
	 * @param string $key key of the object's variable to be returned
	 * @param string $format format to use for the output
	 * @return mixed formatted value of the variable
	 */
	public function getVar($name, $format = 's')
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
	public function getVarForDisplay($name)
	{
		switch ($this->_vars[$name][ConfigOption::TYPE]) {
			case DataType::STRING:
				if (!isset($this->_vars[$name][ConfigOption::AF_DISABLED]) || !$this->_vars[$name][ConfigOption::AF_DISABLED]) {
					$ts = icms_core_Textsanitizer::getInstance();
					$html = !empty($this->_vars['dohtml']) ? 1 : 0;
					$xcode = (!isset($this->_vars['doxcode']) || $this->_vars['doxcode'][ConfigOption::VALUE] == 1) ? 1 : 0;
					$smiley = (!isset($this->_vars['dosmiley']) || $this->_vars['dosmiley'][ConfigOption::VALUE] == 1) ? 1 : 0;
					$image = (!isset($this->_vars['doimage']) || $this->_vars['doimage'][ConfigOption::VALUE] == 1) ? 1 : 0;
					$br = (!isset($this->_vars['dobr']) || $this->_vars['dobr'][ConfigOption::VALUE] == 1) ? 1 : 0;
					if ($html) {
						return $ts->displayTarea($this->_vars[$name][ConfigOption::VALUE], $html, $smiley, $xcode, $image, $br);
					} else {
						return $this->_vars[$name][ConfigOption::VALUE]; //icms_core_DataFilter::checkVar($this->_vars[$name][ConfigOption::VALUE], 'text', 'output');
					}
				} else {
					$ret = str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->_vars[$name][ConfigOption::VALUE], ENT_QUOTES, _CHARSET)); //icms_core_DataFilter::htmlSpecialchars($this->_vars[$name][ConfigOption::VALUE]);
					if (method_exists($this, 'formatForML')) {
						return $this->formatForML($ret);
					} else {
						return $ret;
					}
					return $ret;
				}
			case DataType::INTEGER: // DataType::INTEGER
				return $this->_vars[$name][ConfigOption::VALUE];
			case DataType::FLOAT: // XOBJ_DTYPE_FLOAT
				return sprintf(isset($this->_vars[$name][ConfigOption::FORMAT]) ? $this->_vars[$name][ConfigOption::FORMAT] : '%d', $this->_vars[$name][ConfigOption::VALUE]);
			case DataType::BOOLEAN:
				return $this->_vars[$name][ConfigOption::VALUE] ? _YES : _NO;
			case DataType::FILE: // XOBJ_DTYPE_FILE
				return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->_vars[$name][ConfigOption::VALUE], ENT_QUOTES, _CHARSET));
			case DataType::DATETIME: // XOBJ_DTYPE_LTIME
				return date(isset($this->_vars[$name][ConfigOption::FORMAT]) ? $this->_vars[$name][ConfigOption::FORMAT] : 'r', $this->_vars[$name][ConfigOption::VALUE]);
			case DataType::ARRAY: // XOBJ_DTYPE_ARRAY
				return $this->_vars[$name][ConfigOption::VALUE];
			case DataType::LIST; // XOBJ_DTYPE_SIMPLE_ARRAY
				return $this->_vars[$name][ConfigOption::VALUE];//nl2br(implode("\n", $this->_vars[$name][ConfigOption::VALUE]));
			default:
				return (string)$this->_vars[$name][ConfigOption::VALUE];
		}
	}

	/**
	 * Gets var value for editing
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function getVarForEdit($name)
	{
		switch ($this->_vars[$name][ConfigOption::TYPE]) {
			case DataType::STRING:
			case DataType::INTEGER: // DataType::INTEGER
			case DataType::FLOAT: // XOBJ_DTYPE_FLOAT
			case DataType::BOOLEAN:
			case DataType::FILE: // XOBJ_DTYPE_FILE
			case DataType::DATETIME: // XOBJ_DTYPE_LTIME
			case DataType::ARRAY: // XOBJ_DTYPE_ARRAY
				return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->_vars[$name][ConfigOption::VALUE], ENT_QUOTES, _CHARSET));
			case DataType::LIST: // XOBJ_DTYPE_SIMPLE_ARRAY
				return $this->getVar($name, 'n');
				break;
			case DataType::OBJECT:
			default:
				return null;
		}
	}

	/**
	 * Gets var value for form
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function getVarForForm($name)
	{
		switch ($this->_vars[$name][ConfigOption::TYPE]) {
			case DataType::STRING:
			case DataType::INTEGER: // DataType::INTEGER
			case DataType::FLOAT: // XOBJ_DTYPE_FLOAT
			case DataType::BOOLEAN:
			case DataType::FILE: // XOBJ_DTYPE_FILE
			case DataType::DATETIME: // XOBJ_DTYPE_LTIME
			case DataType::ARRAY: // XOBJ_DTYPE_ARRAY
			case DataType::LIST: // XOBJ_DTYPE_SIMPLE_ARRAY
				return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->_vars[$name][ConfigOption::VALUE], ENT_QUOTES, _CHARSET));
			case DataType::OTHER: // XOBJ_DTYPE_OTHER
			case DataType::OBJECT:
			default:
				return null;
		}
	}

	/**
	 * Magic function to get property value by accessing it by name
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __get($name)
	{
		switch ($name) {
			case '_vars':
			case 'vars':
				if (isset($this->_vars[$name])) {
					return $this->_vars[$name][ConfigOption::VALUE];
				} else {
					trigger_error('Use $this->getVars() of $this->' . $name . ' instead!', E_USER_DEPRECATED);
					return $this->_vars;
				}
			case 'cleanVars':
				trigger_error('Use $this->toArray() of $this->' . $name . ' instead!', E_USER_DEPRECATED);
				return $this->toArray();
			default:
				if (!isset($this->_vars[$name])) {
					$callers = debug_backtrace();
					trigger_error(sprintf('%s undefined for %s (in line %d)', $name, $callers[0]['file'], $callers[0]['line']), E_USER_WARNING);
					return;
				} else {
					return $this->_vars[$name][ConfigOption::VALUE];
				}
		}
	}

	/**
	 * Magic function to work with properties as class variables (set them)
	 *
	 * @param string $name Var name
	 * @param mixed $value New value
	 */
	public function __set($name, $value)
	{
		if (!isset($this->_vars[$name])) {
			return trigger_error('Variable ' . get_class($this) . '::$' . $name . ' not found', E_USER_WARNING);
		}
		if ($this->_vars[$name][ConfigOption::LOCKED]) {
			return trigger_error('Variable ' . get_class($this) . '::$' . $name . ' locked', E_USER_WARNING);
		}
		if (isset($this->_vars[$name][ConfigOption::POSSIBLE_OPTIONS]) && !in_array($value, $this->_vars[$name][ConfigOption::POSSIBLE_OPTIONS])) {
			return trigger_error('Option not in array for variable ' . get_class($this) . '::$' . $name . ' not found', E_USER_WARNING);
		}
		$clean = $this->cleanVar($name, $this->_vars[$name][ConfigOption::TYPE], $value);

		if ($clean === $this->_vars[$name][ConfigOption::VALUE]) {
			return;
		}
		$this->_vars[$name][ConfigOption::VALUE] = $clean;
		$this->setVarInfo($name, ConfigOption::CHANGED, true);
		if (isset($this->_vars[$name][ConfigOption::NOTLOADED]) && $this->_vars[$name][ConfigOption::NOTLOADED]) {
			$this->_vars[$name][ConfigOption::NOTLOADED] = false;
		}
	}

	/**
	 * Returns properties as key-value array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$ret = array();
		foreach (array_keys($this->_vars) as $name) {
			if (isset($this->_vars[$name][ConfigOption::NOTLOADED]) && $this->_vars[$name][ConfigOption::NOTLOADED]) {
				continue;
			}

			if (is_object($this->_vars[$name][ConfigOption::VALUE])) {
				$ret[$name] = serialize($this->_vars[$name][ConfigOption::VALUE]);
			} else {
				$ret[$name] = $this->_vars[$name][ConfigOption::VALUE];
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
	public function getVarInfo($key = null, $info = null, $default = null)
	{
		if ($key === null) {
			return $this->_vars;
		} elseif ($info === null) {
			if (isset($this->_vars[$key])) {
				return $this->_vars[$key];
			} else {
				$callers = debug_backtrace();
				trigger_error(sprintf('%s in %s on line %d doesn\'t exist', $key, $callers[0]['file'], $callers[0]['line']), E_USER_ERROR);
				return $default;
			}
		} elseif (isset($this->_vars[$key][$info])) {
			return $this->_vars[$key][$info];
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
	public function &getVars()
	{
		foreach (array_keys($this->_vars) as $key) {
			$this->_vars[$key][ConfigOption::DEFAULT_VALUE] = $this->cleanVar($key, $this->_vars[$key][ConfigOption::TYPE], isset($this->_vars[$key][ConfigOption::DEFAULT_VALUE]) ? $this->_vars[$key][ConfigOption::DEFAULT_VALUE] : null);
		}
		return $this->_vars;
	}

	/**
	 * Assign values to multiple variables in a batch
	 *
	 * @access public
	 * @param array $var_arr associative array of values to assign
	 * @param bool $not_gpc
	 */
	public function setVars($var_arr, $not_gpc = false)
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
	public function setVar($name, $value, $options = null)
	{
		if ($options !== null) {
			if (is_bool($options)) {
				$this->setVarInfo($name, ConfigOption::NOT_GPC, $options);
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
	public function setVarInfo($key, $info, $value)
	{
		if ($key === null) {
			$key = array_keys($this->_vars);
		}

		if (is_array($key)) {
			foreach ($key as $k) {
				$this->setVarInfo($k, $info, $value);
			}
			return;
		}

		if (!isset($this->_vars[$key])) {
			return trigger_error('Variable ' . get_class($this) . '::$' . $key . ' not found', E_USER_WARNING);
		}

		$this->_vars[$key][$info] = $value;
		switch ($info) {
			case ConfigOption::TYPE:
				$this->$key = $this->_vars[$key][ConfigOption::VALUE];
				break;
			case ConfigOption::CHANGED:
				if ($value) {
					$this->_changed++;
				} else {
					$this->_changed--;
				}
				break;
		}
	}

	/**
	 * Return array of properties names
	 *
	 * @return array
	 */
	public function getVarNames()
	{
		return array_keys($this->_vars);
	}

	/**
	 * Changes type for var
	 *
	 * @param string $key Var name
	 * @param int $type Type
	 *
	 * @deprecated
	 */
	public function setType($key, $type)
	{
		trigger_error('Use not $this->setType() but $this->setVarInfo() instead!', E_USER_DEPRECATED);
		$this->setVarInfo($key, ConfigOption::TYPE, $type);
	}

	/**
	 * Sets field as required
	 *
	 * @param string $key Var name
	 * @param bool $is_required Is required?
	 *
	 * @deprecated
	 */
	public function doSetFieldAsRequired($key, $is_required = true)
	{
		trigger_error('Use not $this->doSetFieldAsRequired() but $this->setVarInfo() instead!', E_USER_DEPRECATED);
		$this->setVarInfo($key, ConfigOption::REQUIRED, $is_required);
	}

	/**
	 * Returns cleaned vars array
	 *
	 * @return array
	 *
	 * @deprecated
	 */
	public function cleanVars()
	{
		trigger_error('Use not $this->cleanVars() but $this->toArray() instead!', E_USER_DEPRECATED);
		return $this->toArray();
	}

}