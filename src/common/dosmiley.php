<?php
/**
 * Code required for common var of dosmiley type
 *
 * @copyright   The ImpressCMS Project http://www.impresscms.org/
 * @license		https://opensource.org/licenses/MIT MIT
 * @author		mekdrop@impresscms.org
 */

if (!defined('_CM_DOSMILEY')) {
    icms_loadLanguageFile('core', 'comment');
}

$value = $default != 'notdefined' ? $default : true;
$this->initVar($varname, icms_properties_Handler::DTYPE_INTEGER,$value, false, null, "", false, _CM_DOSMILEY, '', false, true, $displayOnForm);
$this->setControl($varname, "yesno");