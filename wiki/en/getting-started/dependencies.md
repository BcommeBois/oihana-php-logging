# Dependencies

`oihana/php-logging` deliberately keeps a small runtime footprint. Here is what
it requires and **why**.

## Runtime dependencies

| Package | Used by | Role |
|---|---|---|
| [`psr/log`](https://packagist.org/packages/psr/log) | everything | The `LoggerInterface` contract all components implement or consume. |
| [`psr/container`](https://packagist.org/packages/psr/container) | `LoggerTrait`, `LoggerManagerTrait` | PSR-11 container used to resolve a logger/manager service by id. |
| [`monolog/monolog`](https://packagist.org/packages/monolog/monolog) | `MonoLogManager`, processors | Rotating-file handler, line formatter, `LogRecord` for processors. |
| [`php-di/php-di`](https://packagist.org/packages/php-di/php-di) | `LoggerTrait` | DI exceptions surfaced by the container resolution helpers. |
| [`oihana/php-core`](https://github.com/BcommeBois/oihana-php-core) | `Logger` | `fastFormat()` string interpolation helper. |
| [`oihana/php-enums`](https://github.com/BcommeBois/oihana-php-enums) | `Logger`, `LoggerManager` | `Char`, `Order` enums. |
| [`oihana/php-files`](https://github.com/BcommeBois/oihana-php-files) | `LoggerManager` | `findFiles`, `getFileLines`, `clearFile`, `countFileLines`, `joinPaths`. |
| [`oihana/php-reflect`](https://github.com/BcommeBois/oihana-php-reflect) | enums | `ConstantsTrait` (constant introspection). |
| [`oihana/php-schema`](https://github.com/BcommeBois/oihana-php-schema) | `LoggerManager::createLog()` | The `xyz\oihana\schema\Log` value object returned when parsing a log line. |
| [`oihana/php-traits`](https://github.com/BcommeBois/oihana-php-traits) | `Logger` | `ToStringTrait`. |

## Why so few?

The `Logger` class is **self-contained**: it writes to files using plain PHP
(`fopen`/`fwrite`), so a project that only needs file logging pays almost
nothing. Monolog is only exercised when you actually build a `MonoLogManager`
or use one of the processors.

## Development dependencies

| Package | Role |
|---|---|
| `phpunit/phpunit` | Test runner (strict mode). |
| `nunomaduro/collision` | Readable CLI error output. |
| `mikey179/vfsstream` | Virtual filesystem for `LoggerManager` tests. |
| `phpdocumentor/shim` | API documentation generation. |

## Next steps

- [Loggers](../loggers.md)
- [Managers](../managers.md)
