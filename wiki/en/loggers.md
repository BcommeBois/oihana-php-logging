# Loggers

Two ready-to-use `Psr\Log\LoggerInterface` implementations: a file logger and a
broadcaster.

## `Logger` — daily-file logger

`oihana\logging\Logger` writes log lines to a file named after the current day,
e.g. `log_2026-06-18.log`, inside a directory you choose.

```php
use oihana\logging\Logger;

$logger = new Logger( __DIR__ . '/logs' , Logger::INFO ) ;

$logger->info( 'User {id} signed in' , [ 'id' => 42 ] ) ;
$logger->error( 'Payment failed' ) ;
```

### Constructor

```php
public function __construct( string $directory , int $level = Logger::DEBUG )
```

- `$directory` — the folder where daily files are written. It is created
  (recursively, `0775`) if missing.
- `$level` — the **minimum** severity to record. Use the level constants below.

### Severity levels

| Constant | Value | Constant | Value |
|---|---|---|---|
| `Logger::EMERGENCY` | 0 | `Logger::NOTICE` | 5 |
| `Logger::ALERT` | 1 | `Logger::INFO` | 6 |
| `Logger::CRITICAL` | 2 | `Logger::DEBUG` | 7 |
| `Logger::ERROR` | 3 | `Logger::OFF` | 8 |
| `Logger::WARNING` | 4 | | |

A message is written when its level is **at or below** the configured threshold
(e.g. with `Logger::INFO` (6), `debug()` (7) is dropped). Use `Logger::OFF` to
disable file writing entirely.

### Message interpolation

Context placeholders written as `{key}` are replaced with the matching context
value (scalars and `Stringable` objects only):

```php
$logger->warning( 'Disk {name} at {pct}%' , [ 'name' => 'sda1' , 'pct' => 92 ] ) ;
// 2026-06-18 10:30:00 WARNING Disk sda1 at 92%
```

### Customising the file name

Three public properties control the file name `{prefix}{date}{extension}`:

```php
$logger->prefix         = 'app_' ;   // default 'log_'
$logger->fileDateFormat = 'Y-m' ;    // default 'Y-m-d' (one file per month)
$logger->extension      = '.txt' ;   // default '.log'
```

### Maintenance & introspection helpers

```php
$logger->getDirectory() ;   // the log directory
$logger->getPath() ;        // full path of today's file
$logger->getLogFiles() ;    // every file name in the directory
$logger->getStatus() ;      // Logger::STATUS_LOG_OPEN | STATUS_OPEN_FAILED | STATUS_LOG_CLOSED
$logger->getErrors() ;      // internal message buffer (open/permission diagnostics)
$logger->clear() ;          // delete every log file in the directory
$logger->writeFreeFormLine( 'raw line, no timestamp' ) ;
```

### Global error / exception hooks

`onError()` and `onException()` adapt the logger to PHP's global handlers:

```php
set_error_handler    ( [ $logger , 'onError' ] ) ;
set_exception_handler( [ $logger , 'onException' ] ) ;
```

## `CompositeLogger` — broadcast to many loggers

`oihana\logging\CompositeLogger` implements `LoggerInterface` and forwards every
call to each registered logger. It stores its children in a `WeakMap`, so a
logger is **automatically dropped** once no other reference to it remains.

```php
use oihana\logging\Logger;
use oihana\logging\CompositeLogger;

$composite = new CompositeLogger([
    new Logger( __DIR__ . '/logs' ) ,
    $myMonologLogger ,
]) ;

$composite->error( 'Broadcast to every registered logger' ) ;
```

### API

```php
$composite->addLogger( $logger ) ;     // register (chainable)
$composite->removeLogger( $logger ) ;  // unregister by reference (chainable)
$composite->hasLogger( $logger ) ;     // bool
$composite->getLoggers() ;             // LoggerInterface[] currently alive
$composite->clear() ;                  // drop all (chainable)
$composite->count ;                    // number of registered loggers (property hook)
```

## Next steps

- [Managers](managers.md) — build a Monolog logger from options.
- [Traits](traits.md) — add logging to your own classes.
