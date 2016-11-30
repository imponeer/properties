<?php
/**
 * Code required for common var of custom_css type
 *
 * @copyright   The ImpressCMS Project http://www.impresscms.org/
 * @license		https://opensource.org/licenses/MIT MIT
 * @author		mekdrop@impresscms.org
 */

$value = $default != 'notdefined' ? $default : '';
$this->initVar($varname, icms_properties_Handler::DTYPE_STRING, $value, false, null, '', false, _CO_ICMS_CUSTOM_CSS, _CO_ICMS_CUSTOM_CSS_DSC, false, true, $displayOnForm);
$this->setControl('custom_css', array(
                    'name' => 'textarea',
                    'form_editor'=>'textarea',
    )
);