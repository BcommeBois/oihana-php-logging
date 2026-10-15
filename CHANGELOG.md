# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.2] - 2026-10-15

### Fixed
- **A log file gets the permissions it was given, whatever their form.**
  `MonoLogManager` passed `filePermissions` to `octdec()` without looking at
  it, while its default, `0664`, is already an octal integer : read again as
  if it were written in decimal, it became `0436` (`r-- -wx rw-`) — the owner
  could no longer write to its own log file. Every new file of the rotating
  handler was born so whenever `filePermissions` was left out, or given as an
  integer as the class docblock showed (`'filePermissions' => 0664`) ; only
  an octal string (`"0664"`) was read right. It is now read like
  `LoggerManager` reads `dirPermissions` : a string is converted with
  `octdec()`, an integer is taken as is. Files already created keep their
  permissions.
  - **Docs:** the `MonoLogManager` docblocks (both forms, and an example
    written `0o664`) ; `wiki/{fr,en}/managers.md` — `DIR_PERMISSIONS` and
    `FILE_PERMISSIONS` accept an octal integer or an octal string.
  - **Tests:** `MonoLogManagerTest` — absent, octal strings and octal integers
    all give the permissions asked, the expected values written as octal
    literals, never computed by `octdec()` ; a real log file is created
    `0664` on disk. Back to the former line, `(int)` alone or the guard
    inverted : the suite goes red each time.

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
