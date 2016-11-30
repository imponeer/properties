<?php
/**
 * Code required for common var of dohtml type
 *
 * @copyright   The ImpressCMS Project http://www.impresscms.org/
 * @license		https://opensource.org/licenses/MIT MIT
 * @author		mekdrop@impresscms.org
 */

if (!defined('_CM_DOHTML')) {
    icms_loadLanguageFile('core', 'comment');
}

$value = $default != 'notdefined' ? $default : true;
$this->initVar($varname, \ImpressCMS\Properties::DTYPE_INTEGER, $value, false, null, "", false, _CM_DOHTML, '', false, true, $displayOnForm);
$this->setControl($varname, "yesno");