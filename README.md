[![License](https://img.shields.io/github/license/imponeer/properties.svg?maxAge=2592000)](LICENSE.md) [![GitHub release](https://img.shields.io/github/release/imponeer/properties.svg?maxAge=2592000)](https://github.com/imponeer/properties/releases) [![Tests](https://github.com/imponeer/properties/actions/workflows/on-pull-request.yml/badge.svg?branch=main)](https://github.com/imponeer/properties/actions/workflows/on-pull-request.yml) [![Packagist](https://img.shields.io/packagist/dm/imponeer/properties.svg)](https://packagist.org/packages/imponeer/properties)

# Properties

PHP library that lets you define strict, validated class variables (with change tracking and serialization helpers) in one place and reuse them across your own domain classes.

## Installation

`composer require imponeer/properties`

## Usage

Quick start:
1. Extend `Imponeer\Properties\PropertiesSupport` (or implement `PropertiesInterface` yourself).
2. Define each property in the constructor with `initVar()` using a `DataType` enum (or the legacy `DTYPE_*` constants available on `PropertiesInterface`).
3. Use the generated magic accessors or helper methods like `toArray()`/`assignVars()` as you would with normal public properties.

```php
use DateTimeImmutable;
use Imponeer\Properties\Enum\DataType;
use Imponeer\Properties\PropertiesSupport;

final class Article extends PropertiesSupport
{
    public function __construct()
    {
        $this->initVar('id', DataType::INTEGER, null, true);
        $this->initVar('title', DataType::STRING, 'Untitled', true, ['maxlength' => 150]);
        $this->initVar('published_at', DataType::DATETIME, null, false);
    }
}

$article = new Article();
$article->title = 'Hello world';
$article->published_at = new DateTimeImmutable();

var_dump($article->toArray()); // Strictly typed values, ready to persist or render
```

## How to contribute?

If you want to add some functionality or fix bugs, you can fork, change and create pull request. If you are new to Git or GitHub, start with the [GitHub Skills “Introduction to GitHub” course](https://skills.github.com/).

If you found any bug or have some questions, use [issues tab](https://github.com/imponeer/properties/issues) and write there your questions.
