<?php
/**
 * Code required for common var of short_url type
 *
 * @copyright   The ImpressCMS Project http://www.impresscms.org/
 * @license		https://opensource.org/licenses/MIT MIT
 * @author		mekdrop@impresscms.org
 */

$value = $default != 'notdefined' ? $default : '';
$this->initVar($varname, icms_properties_Handler::DTYPE_STRING,$value, false, 255, "", false, _CO_ICMS_SHORT_URL, _CO_ICMS_SHORT_URL_DSC, false, true, $displayOnForm);