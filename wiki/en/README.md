# oihana/php-logging — PSR-3 logging toolkit for PHP

![Language](https://img.shields.io/badge/language-English-blue)

`oihana/php-logging` is a PHP 8.4+ library providing a small set of **PSR-3** logging building blocks: a self-contained daily-file `Logger`, a `CompositeLogger` that fans out to several loggers, a **Monolog**-based rotating-file manager, three composable traits, two configuration enums and two Monolog processors.

![Oihana PHP Logging](https://raw.githubusercontent.com/BcommeBois/oihana-php-logging/main/assets/images/oihana-php-logging-logo-inline-512x160.png)

## Who this documentation is for

PHP developers who want to:

- write log lines to **dated files** with no external dependency — `oihana\logging\Logger`;
- **broadcast** the same log call to many PSR-3 loggers at once — `CompositeLogger`;
- build a **Monolog** rotating-file logger from a plain options array — `MonoLogManager`;
- add **PSR-3 logging** to any class through a trait — `LoggerTrait`, `DebugTrait`;
- decorate Monolog records with an **emoji or symbol** per level — `EmojiProcessor`, `SymbolProcessor`.

## Quick start

```php
use oihana\logging\Logger;

$logger = new Logger( __DIR__ . '/logs' , Logger::INFO ) ;

$logger->info( 'Application started' ) ;
$logger->error( 'Connection to {host} failed' , [ 'host' => 'db-1' ] ) ;
// → logs/log_2026-06-18.log
```

For full details (options, enums, contracts), see the table of contents below.

## Table of contents

### Getting started — [`getting-started/`](getting-started/)

- [Introduction](getting-started/introduction.md) — what the library does and the *oihana* philosophy.
- [Installation](getting-started/installation.md) — PHP 8.4+ requirement and `composer require`.
- [Dependencies](getting-started/dependencies.md) — Monolog, PHP-DI, the `oihana/*` packages and their role.

### Usage

- [Loggers](loggers.md) — `Logger` (daily-file, PSR-3) and `CompositeLogger` (broadcast).
- [Managers](managers.md) — `LoggerManager` (abstract base) and `MonoLogManager` (Monolog factory).
- [Traits](traits.md) — `LoggerTrait`, `LoggerManagerTrait`, `DebugTrait`.
- [Processors](processors.md) — `EmojiProcessor` and `SymbolProcessor` for Monolog.
- [Enumerations](enums.md) — `LoggerParam`, `MonoLogParam` configuration keys.

### Cross-cutting

- [Tests & coverage](testing.md) — run the PHPUnit suite and measure coverage.

## Source code

The library code lives under [`src/oihana/logging/`](../../src/oihana/logging/) — namespace `oihana\logging`.

## See also

- [Packagist `oihana/php-logging`](https://packagist.org/packages/oihana/php-logging) — the package page.
- [API reference (phpDocumentor)](https://bcommebois.github.io/oihana-php-logging) — class-level generated reference.
