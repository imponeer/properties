<?php
/**
 * This file is for binding old Xoops types to new Properties types
 *
 * @deprecated
 */

use \Imponeer\Properties\PropertiesInterface;

define('XOBJ_DTYPE_TXTBOX', PropertiesInterface::DTYPE_DEP_TXTBOX);
define('XOBJ_DTYPE_TXTAREA', PropertiesInterface::DTYPE_STRING);
define('XOBJ_DTYPE_STRING', PropertiesInterface::DTYPE_STRING);
define('XOBJ_DTYPE_INT', PropertiesInterface::DTYPE_INTEGER); // shorthund
define('XOBJ_DTYPE_INTEGER', PropertiesInterface::DTYPE_INTEGER);
define('XOBJ_DTYPE_URL', PropertiesInterface::DTYPE_DEP_URL);
define('XOBJ_DTYPE_EMAIL', PropertiesInterface::DTYPE_DEP_EMAIL);
define('XOBJ_DTYPE_ARRAY', PropertiesInterface::DTYPE_ARRAY);
define('XOBJ_DTYPE_OTHER', PropertiesInterface::DTYPE_OTHER);
define('XOBJ_DTYPE_SOURCE', PropertiesInterface::DTYPE_DEP_SOURCE);
define('XOBJ_DTYPE_STIME', PropertiesInterface::DTYPE_DEP_STIME);
define('XOBJ_DTYPE_MTIME', PropertiesInterface::DTYPE_DEP_MTIME);
define('XOBJ_DTYPE_DATETIME', PropertiesInterface::DTYPE_DATETIME);
define('XOBJ_DTYPE_LTIME', PropertiesInterface::DTYPE_DATETIME);
define('XOBJ_DTYPE_SIMPLE_ARRAY', PropertiesInterface::DTYPE_LIST);
define('XOBJ_DTYPE_CURRENCY', PropertiesInterface::DTYPE_DEP_CURRENCY);
define('XOBJ_DTYPE_FLOAT', PropertiesInterface::DTYPE_FLOAT);
define('XOBJ_DTYPE_TIME_ONLY', PropertiesInterface::DTYPE_DEP_TIME_ONLY);
define('XOBJ_DTYPE_URLLINK', PropertiesInterface::DTYPE_DEP_URLLINK);
define('XOBJ_DTYPE_FILE', PropertiesInterface::DTYPE_DEP_FILE);
define('XOBJ_DTYPE_IMAGE', PropertiesInterface::DTYPE_DEP_IMAGE);
define('XOBJ_DTYPE_FORM_SECTION', PropertiesInterface::DTYPE_DEP_FORM_SECTION);
define('XOBJ_DTYPE_FORM_SECTION_CLOSE', PropertiesInterface::DTYPE_DEP_FORM_SECTION_CLOSE);