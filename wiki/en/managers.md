# Managers

A *manager* owns the lifecycle of log files: where they live, how they are
named, how to read/count/clear them, and how to build the actual PSR-3 logger.

## `LoggerManager` — abstract base

`oihana\logging\LoggerManager` is an abstract class providing file-management
utilities around a log directory. Subclasses implement the single abstract
method `createLogger()`.

### Construction

```php
public function __construct( array $init = [] , ?string $name = null )
```

The `$init` array is keyed by [`LoggerParam`](enums.md):

| Key (`LoggerParam::`) | Default | Meaning |
|---|---|---|
| `DIRECTORY` | `''` | Base log directory. |
| `PATH` | `''` | Sub-folder inside the base directory. |
| `EXTENSION` | `.log` | Log file extension. |
| `DIR_PERMISSIONS` | `0775` | Permissions for created directories. |

`$name` is the optional channel name, used as the default file base name.

### File-management API

```php
$m->getDirectory() ;          // <directory>/<path>
$m->getFileName() ;           // <name> or 'log'
$m->getExtension() ;          // '.log'
$m->getFilePath( $file ) ;    // full path of a given file (or the default one)
$m->ensureDirectory() ;       // create + assert writable (throws DirectoryException)

$m->countLines( 'log_2026-06-18.log' ) ;   // int
$m->clear( 'log_2026-06-18.log' ) ;        // bool — empties the file
$m->getLoggerFiles() ;                      // string[] matching '<name>*<extension>', sorted asc
$m->getLogLines( null ) ;                   // parse the default file into Log entries
$m->createLog( '2026-06-18 10:30:00 INFO Hi' ) ; // ?xyz\oihana\schema\Log
```

`createLog()` splits a line into a `Log` value object
(`date`, `time`, `level`, `message`); it returns `null` for empty or malformed
lines.

### Writing your own manager

```php
use oihana\logging\LoggerManager;
use oihana\logging\Logger;
use Psr\Log\LoggerInterface;

$manager = new class([ 'directory' => '/var/log/myapp' ]) extends LoggerManager
{
    public function createLogger(): LoggerInterface
    {
        return new Logger( $this->getDirectory() );
    }
};

$manager->ensureDirectory();
$logger = $manager->createLogger();
```

## `MonoLogManager` — Monolog rotating-file factory

`oihana\logging\MonoLogManager` extends `LoggerManager` and builds a fully
configured **Monolog** logger with a `RotatingFileHandler` and a
`LineFormatter`.

```php
use oihana\logging\MonoLogManager;
use Monolog\Level;

$manager = new MonoLogManager
([
    'directory'             => '/var/log/myapp' ,
    'level'                 => Level::Info ,
    'maxFiles'              => 7 ,
    'allowInlineLineBreaks' => true ,
] , name: 'myapp' ) ;

$logger = $manager->createLogger() ; // Monolog\Logger (PSR-3)
$logger->info( 'Application started' ) ;
```

`createLogger()` also registers the logger with Monolog's `ErrorHandler`, so PHP
errors and uncaught exceptions are captured automatically.

### Options

The `$init` array is keyed by [`MonoLogParam`](enums.md):

| Key (`MonoLogParam::`) | Default | Meaning |
|---|---|---|
| `LEVEL` | `Level::Debug` | Minimum level (a `Monolog\Level` or int). |
| `MAX_FILES` | `0` | Number of rotated files kept (`0` = keep all). |
| `BUBBLES` | `true` | Whether records bubble to other handlers. |
| `FILE_PERMISSIONS` | `0664` | Permissions of created log files. |
| `DATE_FORMAT` | `Y-m-d H:i:s` | Date format in each line. |
| `FORMAT` | `%datetime% %channel% %level_name% %message% %context% %extra%\n` | Line format. |
| `ALLOW_INLINE_LINE_BREAKS` | `true` | Keep multi-line messages inline. |
| `IGNORE_EMPTY_CONTEXT_AND_EXTRA` | `true` | Drop empty `context`/`extra`. |
| `INCLUDE_STACK_TRACES` | `false` | Include exception stack traces. |

The `LineFormatter` is built lazily and cached; retrieve it with
`getFormatter()`.

## Next steps

- [Processors](processors.md) — decorate Monolog records per level.
- [Enumerations](enums.md) — the configuration keys in full.
