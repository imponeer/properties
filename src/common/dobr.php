<?php
/**
 * Code required for common var of dobr type
 *
 * @copyright   The ImpressCMS Project http://www.impresscms.org/
 * @license		https://opensource.org/licenses/MIT MIT
 * @author		mekdrop@impresscms.org
 */

if (!defined('_CM_DOAUTOWRAP')) {
    icms_loadLanguageFile('core', 'comment');
}

$value = ($default === 'notdefined') ? true : $default;
$this->initVar($varname, \ImpressCMS\Properties::DTYPE_INTEGER,$value, false, null, "", false, _CM_DOAUTOWRAP, '', false, true, $displayOnForm);
$this->setControl($varname, "yesno");