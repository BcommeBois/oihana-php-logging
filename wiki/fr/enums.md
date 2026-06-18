# Énumérations

Les clés de configuration sont exposées sous forme de **constantes typées**
regroupées dans des classes utilitaires, plutôt que de *magic strings*
dispersées dans le code. Les deux classes utilisent
`oihana\reflect\traits\ConstantsTrait`, ce qui permet de les introspecter
(`::getConstants()`, `::getConstant()`, `::includes()`…).

## `LoggerParam`

`oihana\logging\enums\LoggerParam` — clés acceptées par les constructeurs de
[`LoggerManager`](managers.md) et les traits de journalisation.

| Constante | Valeur |
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

`oihana\logging\enums\MonoLogParam` — clés acceptées par
[`MonoLogManager`](managers.md).

| Constante | Valeur |
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

Voir [Managers](managers.md) pour la signification et la valeur par défaut de
chaque option.

## Étapes suivantes

- [Managers](managers.md)
- [Tests & couverture](testing.md)
