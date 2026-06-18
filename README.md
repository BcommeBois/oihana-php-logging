# Oihana PHP - Logging

![Oihana PHP Logging](https://raw.githubusercontent.com/BcommeBois/oihana-php-logging/main/assets/images/oihana-php-logging-logo-inline-512x160.png)

A lightweight, PSR-3 logging toolkit for PHP 8.4+.

[![Latest Version](https://img.shields.io/packagist/v/oihana/php-logging.svg?style=flat-square)](https://packagist.org/packages/oihana/php-logging)  
[![Total Downloads](https://img.shields.io/packagist/dt/oihana/php-logging.svg?style=flat-square)](https://packagist.org/packages/oihana/php-logging)  
[![License](https://img.shields.io/packagist/l/oihana/php-logging.svg?style=flat-square)](LICENSE)

## 📚 Documentation

User guides (FR + EN), with narrative explanations and examples:

| | |
|---|---|
| 🇬🇧 **[English documentation](wiki/en/README.md)** | 🇫🇷 **[Documentation française](wiki/fr/README.md)** |
| Getting started, loggers, managers, traits, processors, enums, tips. | Démarrage, loggers, managers, traits, processeurs, énumérations, astuces. |

Auto-generated API reference (phpDocumentor):  
👉 https://bcommebois.github.io/oihana-php-logging

## 🚀 Features

- 🪵 A PSR-3 compliant, daily-file `Logger` with message interpolation and global error/exception hooks.
- 🧩 A `CompositeLogger` that broadcasts log calls to many PSR-3 loggers (WeakMap-based auto-cleanup).
- 🔄 A Monolog-based rotating-file manager (`MonoLogManager`) and a reusable `LoggerManager` base class.
- 🧰 Composable logger traits — `LoggerTrait`, `LoggerManagerTrait`, `DebugTrait`.
- ✨ Custom Monolog processors — emoji and symbol level decorators.
- 🧪 Full unit-test coverage ensuring reliability and maintainability.

💡 Designed to be lightweight, testable, and compatible with any PHP 8.4+ project.

## 📦 Installation

> **Requires [PHP 8.4+](https://php.net/releases/)**  

Install via [Composer](https://getcomposer.org):
```bash
composer require oihana/php-logging
```

## ✅ Tests & coverage

Run the full unit-test suite (PHPUnit, strict mode):
```bash
composer test
```

Run a single test case:
```bash
./vendor/bin/phpunit --filter CompositeLoggerTest
```

Measure coverage (requires Xdebug or PCOV):
```bash
composer coverage        # text + Clover + HTML under build/coverage/
composer coverage:md     # readable Markdown summary (build/coverage/COVERAGE.md)
```

The suite runs in **strict mode** and targets **100% line coverage**.

## 🧾 License

This project is licensed under the [Mozilla Public License 2.0 (MPL-2.0)](https://www.mozilla.org/en-US/MPL/2.0/).

## 👤 About the author

* Author : Marc ALCARAZ (aka eKameleon)
* Mail : marc@ooop.fr
* Website : http://www.ooop.fr

## 🛠️ Generate the Documentation

We use [phpDocumentor](https://phpdoc.org/) to generate the documentation into the ./docs folder.

### Usage
Run the command : 
```bash
composer doc
```

## 🔗 Related packages

- `oihana/php-core` – core helpers and utilities used by this library: `https://github.com/BcommeBois/oihana-php-core`
- `oihana/php-files` – file and path handling utilities: `https://github.com/BcommeBois/oihana-php-files`
- `oihana/php-enums` – a collection of strongly-typed constant enumerations for PHP: `https://github.com/BcommeBois/oihana-php-enums`
