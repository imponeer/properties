<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 8:46 PM
 *
 * This file is for binding old Xoops types to new Properties types
 *
 * @deprecated
 */

define('XOBJ_DTYPE_TXTBOX', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_TXTBOX);
define('XOBJ_DTYPE_TXTAREA', \IPFLibraries\Properties\PropertiesInterface::DTYPE_STRING);
define('XOBJ_DTYPE_STRING', \IPFLibraries\Properties\PropertiesInterface::DTYPE_STRING);
define('XOBJ_DTYPE_INT', \IPFLibraries\Properties\PropertiesInterface::DTYPE_INTEGER); // shorthund
define('XOBJ_DTYPE_INTEGER', \IPFLibraries\Properties\PropertiesInterface::DTYPE_INTEGER);
define('XOBJ_DTYPE_URL', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_URL);
define('XOBJ_DTYPE_EMAIL', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_EMAIL);
define('XOBJ_DTYPE_ARRAY', \IPFLibraries\Properties\PropertiesInterface::DTYPE_ARRAY);
define('XOBJ_DTYPE_OTHER', \IPFLibraries\Properties\PropertiesInterface::DTYPE_OTHER);
define('XOBJ_DTYPE_SOURCE', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_SOURCE);
define('XOBJ_DTYPE_STIME', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_STIME);
define('XOBJ_DTYPE_MTIME', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_MTIME);
define('XOBJ_DTYPE_DATETIME', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DATETIME);
define('XOBJ_DTYPE_LTIME', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DATETIME);
define('XOBJ_DTYPE_SIMPLE_ARRAY', \IPFLibraries\Properties\PropertiesInterface::DTYPE_LIST);
define('XOBJ_DTYPE_CURRENCY', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_CURRENCY);
define('XOBJ_DTYPE_FLOAT', \IPFLibraries\Properties\PropertiesInterface::DTYPE_FLOAT);
define('XOBJ_DTYPE_TIME_ONLY', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_TIME_ONLY);
define('XOBJ_DTYPE_URLLINK', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_URLLINK);
define('XOBJ_DTYPE_FILE', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_FILE);
define('XOBJ_DTYPE_IMAGE', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_IMAGE);
define('XOBJ_DTYPE_FORM_SECTION', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_FORM_SECTION);
define('XOBJ_DTYPE_FORM_SECTION_CLOSE', \IPFLibraries\Properties\PropertiesInterface::DTYPE_DEP_FORM_SECTION_CLOSE);