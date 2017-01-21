[![License](https://img.shields.io/github/license/IPFLibraries/properties.svg?maxAge=2592000)](License.txt) [![GitHub release](https://img.shields.io/github/release/IPFLibraries/properties.svg?maxAge=2592000)](https://github.com/ImpressCMS/impresscms/releases) [![Build Status](https://travis-ci.org/IPFLibraries/properties.svg?branch=master)](https://travis-ci.org/IPFLibraries/properties) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/IPFLibraries/properties/badges/quality-score.png)](https://scrutinizer-ci.com/g/IPFLibraries/properties/)

# Properties

PHP library for handling strict type class variables. This package can be used only for adding functionality for other classes.

##Installation

`composer require ipf-libraries/properties`

## Usage

To add some custom properties support to a class first you need to extend that class. Here is example how to do it:
```php5
use ImpressCMS\Properties;

class Base extends Properties {

}
```
Next thing what you need is to define variables in class constructor. Here an example how to do:
```php5
use ImpressCMS\Properties;

class Base extends Properties {

  public function __construct() {
    $this->initVar('varA', self::DTYPE_INTEGER, null, false);
    $this->initVar('varB', self::DTYPE_STRING, null, true, 150);
    $this->initVar('varC', self::DTYPE_INTEGER, 100, false);
  }
}
```
Than is possible to use such vars. This would work for previous example in such way:
```php5

// Creates instance
$obj = new Base();

// Print current objects vars
var_dump($obj->toArray());

// Modify vars with some integer values and prints
$obj->varA = 57;
$obj->varB = 58;
$obj->varC = 59;
var_dump($obj->toArray());

// Modify vars with some string values and prints
$obj->varA = "A";
$obj->varB = "B";
$obj->varC = "C";
var_dump($obj->toArray());

```
