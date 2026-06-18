# Introduction

`oihana/php-logging` gathers the logging building blocks that used to live inside `oihana/php-system`, extracted into a focused, lightweight package so that a project can depend on logging **without** pulling an HTTP stack, a templating engine or a database layer.

Everything is built around the **PSR-3** standard (`Psr\Log\LoggerInterface`), so the components interoperate with any PSR-3 consumer or producer (Symfony, Laravel, Monolog handlers, etc.).

## What it provides

| Component | Type | Role |
|---|---|---|
| `Logger` | class | Self-contained, PSR-3, daily-file logger (no external dependency). |
| `CompositeLogger` | class | Broadcasts every log call to several PSR-3 loggers (WeakMap-based). |
| `LoggerManager` | abstract class | Base class to manage log files (read, count, clear, list, parse). |
| `MonoLogManager` | class | Builds a **Monolog** rotating-file logger from an options array. |
| `LoggerTrait` | trait | Adds PSR-3 logging to any class, with DI-container resolution. |
| `LoggerManagerTrait` | trait | Injects a `LoggerManager` into any class. |
| `DebugTrait` | trait | Adds `debug` / `mock` flags on top of `LoggerTrait`. |
| `EmojiProcessor` / `SymbolProcessor` | classes | Monolog processors decorating records per level. |
| `LoggerParam` / `MonoLogParam` | enums | Strongly-typed configuration keys (no *magic strings*). |

## The *oihana* philosophy

- **PHP 8.4+ only** — typed constants, property hooks, `WeakMap`, no legacy shims.
- **No *magic strings*** — every configuration key is a typed constant in an enum (`LoggerParam`, `MonoLogParam`).
- **Composable** — each trait has a single responsibility and can be combined freely.
- **Tested** — 100% line coverage, strict PHPUnit mode (see [Tests & coverage](../testing.md)).

## Next steps

- [Installation](installation.md)
- [Dependencies](dependencies.md)
- [Loggers](../loggers.md)
