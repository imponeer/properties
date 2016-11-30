<?php
/**
 * Code required for common var of doxcode type
 *
 * @copyright   The ImpressCMS Project http://www.impresscms.org/
 * @license		https://opensource.org/licenses/MIT MIT
 * @author		mekdrop@impresscms.org
 */

$value = $default != 'notdefined' ? $default : true;
$this->initVar($varname, \ImpressCMS\Properties::DTYPE_INTEGER,$value, false, null, "", false, _CO_ICMS_DOXCODE_FORM_CAPTION, '', false, true, $displayOnForm);
$this->setControl($varname, "yesno");