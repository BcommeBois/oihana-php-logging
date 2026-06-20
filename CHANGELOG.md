# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.1] - 2026-06-20

### Changed
- Depend on `oihana/php-traits` instead of `oihana/php-system`. The package
  only used `oihana\traits\ToStringTrait`; switching to the dedicated package
  drops the heavy transitive stack (slim, twig, somnambulist, scrapbook,
  symfony/cache) from the dependency tree. Public API and 100% coverage
  unchanged.

## [1.0.0] - 2026-06-19

First public release. The `oihana\logging` namespace is extracted from
`oihana/php-system` into its own focused, PSR-3 logging package.

### Added
- Initial project scaffolding: `composer.json`, `phpunit.xml`, `phpdoc.xml`,
  CI and Docs GitHub workflows, coverage tooling, phpDocumentor template,
  README, CONTRIBUTING and license.
- Brand assets (logos) under `assets/images/`.
- PSR-3 logging library under the `oihana\logging` namespace, imported from
  `oihana/php-system`:
  - `Logger` — daily-file PSR-3 logger with message interpolation.
  - `CompositeLogger` — broadcasts to many PSR-3 loggers (WeakMap-based).
  - `LoggerManager` / `MonoLogManager` — log-file management and a
    Monolog rotating-file logger factory.
  - `LoggerTrait`, `LoggerManagerTrait`, `DebugTrait` — composable traits.
  - `enums\LoggerParam`, `enums\MonoLogParam` — configuration keys.
  - `monolog\processors\EmojiProcessor`, `monolog\processors\SymbolProcessor`.
- Unit-test suite imported from `oihana/php-system` (PHPUnit, strict mode),
  plus one extra `LoggerTrait` test covering the default-service fallback.
  **100% line coverage** (231/231 lines, 64/64 methods, 9/9 classes), 84 tests.
- Bilingual user guide under `wiki/` (English + French): getting started
  (introduction, installation, dependencies), loggers, managers, traits,
  Monolog processors, enums and a testing guide.

[1.0.0]: https://github.com/BcommeBois/oihana-php-logging/releases/tag/1.0.0
