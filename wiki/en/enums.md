# Enumerations

Configuration keys are exposed as **typed constants** grouped in helper classes,
instead of *magic strings* scattered through the codebase. Both classes use
`oihana\reflect\traits\ConstantsTrait`, so you can introspect them
(`::getConstants()`, `::getConstant()`, `::includes()`…).

## `LoggerParam`

`oihana\logging\enums\LoggerParam` — keys accepted by
[`LoggerManager`](managers.md) constructors and the logging traits.

| Constant | Value |
|---|---|
| `LoggerParam::DIRECTORY` | `'directory'` |
| `LoggerParam::DIR_PERMISSIONS` | `'dirPermissions'` |
| `LoggerParam::EXTENSION` | `'extension'` |
| `LoggerParam::LOGGABLE` | `'loggable'` |
| `LoggerParam::LOGGER` | `'logger'` |
| `LoggerParam::NAME` | `'name'` |
| `LoggerParam::PATH` | `'path'` |

```php
use oihana\logging\enums\LoggerParam;
use oihana\logging\MonoLogManager;

$manager = new MonoLogManager([
    LoggerParam::DIRECTORY => '/var/log/myapp' ,
    LoggerParam::PATH      => 'http' ,
]);
```

## `MonoLogParam`

`oihana\logging\enums\MonoLogParam` — keys accepted by
[`MonoLogManager`](managers.md).

| Constant | Value |
|---|---|
| `MonoLogParam::ALLOW_INLINE_LINE_BREAKS` | `'allowInlineLineBreaks'` |
| `MonoLogParam::IGNORE_EMPTY_CONTEXT_AND_EXTRA` | `'ignoreEmptyContextAndExtra'` |
| `MonoLogParam::BUBBLES` | `'bubbles'` |
| `MonoLogParam::DATE_FORMAT` | `'dateFormat'` |
| `MonoLogParam::DIR_PERMISSIONS` | `'dirPermissions'` |
| `MonoLogParam::FILE_PERMISSIONS` | `'filePermissions'` |
| `MonoLogParam::FORMAT` | `'format'` |
| `MonoLogParam::INCLUDE_STACK_TRACES` | `'includeStackTraces'` |
| `MonoLogParam::LEVEL` | `'level'` |
| `MonoLogParam::MAX_FILES` | `'maxFiles'` |
| `MonoLogParam::PATTERN` | `'pattern'` |

See [Managers](managers.md) for the meaning and default of each option.

## Next steps

- [Managers](managers.md)
- [Tests & coverage](testing.md)
