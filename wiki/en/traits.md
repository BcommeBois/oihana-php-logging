# Traits

Three composable traits to bring logging capabilities into your own classes,
each with a single responsibility.

## `LoggerTrait` — PSR-3 logging for any class

`oihana\logging\LoggerTrait` builds on `Psr\Log\LoggerAwareTrait` and exposes
every PSR-3 level method (`emergency()` … `debug()`), all guarded by a
null-safe call — so they are safe no-ops when no logger is set.

```php
use oihana\logging\LoggerTrait;
use Psr\Log\LoggerInterface;

class MyService
{
    use LoggerTrait;

    public function __construct( ?LoggerInterface $logger = null )
    {
        $this->initializeLogger( $logger );
    }

    public function run(): void
    {
        $this->info( 'Service started' );
    }
}
```

### Constants & state

| Member | Meaning |
|---|---|
| `LoggerTrait::LOGGER` (`'logger'`) | Array key used to read a logger from an init array. |
| `LoggerTrait::LOGGABLE` (`'loggable'`) | Array/container key used by `initializeLoggable()`. |
| `bool $loggable` | A flag you can check before logging. |

### `initializeLogger()`

```php
public function initializeLogger(
    array|LoggerInterface|string|null $init = null ,
    ?ContainerInterface               $container = null ,
    bool                              $useDefault = true
) : static
```

Accepts:

- a **`LoggerInterface`** instance → used directly;
- an **array** containing the logger under the `LOGGER` key;
- a **string** service id / class name → resolved from `$container`;
- **`null`** → when `$useDefault` is `true` (the default), falls back to
  resolving `LoggerInterface::class` from the container.

If nothing resolves to a `LoggerInterface`, `$this->logger` is set to `null`
(and the level methods become no-ops).

```php
$service->initializeLogger( 'my-logger' , $container ) ;          // by service id
$service->initializeLogger( [ 'logger' => $psrLogger ] ) ;        // from an array
$service->initializeLogger( null , $container ) ;                 // default service
```

### `initializeLoggable()`

```php
public function initializeLoggable(
    bool|array|null     $init = null ,
    ?ContainerInterface $container = null ,
    bool                $defaultValue = false
) : static
```

Sets the `$loggable` flag from a boolean, an array (`LOGGABLE` key), or a
container entry named `loggable`.

## `LoggerManagerTrait` — inject a `LoggerManager`

`oihana\logging\LoggerManagerTrait` adds a `?LoggerManager $manager` property
and a resolver.

```php
use oihana\logging\LoggerManagerTrait;

class LogReader
{
    use LoggerManagerTrait;

    public function __construct( $manager , $container = null )
    {
        $this->initializeLoggerManager( $manager , $container );
    }
}
```

`initializeLoggerManager( LoggerManager|string|null $manager, ?ContainerInterface $container = null )`
accepts an instance, or a service id resolved from the container; anything else
leaves `$manager` as `null`.

## `DebugTrait` — debug & mock flags

`oihana\logging\DebugTrait` **uses `LoggerTrait`** and adds two boolean modes:
`debug` and `mock`. Mock mode is only active when debug mode is too.

```php
use oihana\logging\DebugTrait;

class MyService
{
    use DebugTrait;
}

$service = ( new MyService() )
    ->initializeDebug([ DebugTrait::DEBUG => true ])
    ->initializeMock ([ DebugTrait::MOCK  => true ]);

$service->isDebug(); // true
$service->isMock();  // true  (would be false if debug were off)
```

| Member | Meaning |
|---|---|
| `DebugTrait::DEBUG` (`'debug'`) / `bool $debug` | Debug-mode key and flag. |
| `DebugTrait::MOCK` (`'mock'`) / `bool $mock` | Mock-mode key and flag. |
| `initializeDebug(array, bool)` / `initializeMock(array, bool)` | Set the flags (non-boolean values fall back to the default). |
| `isDebug(array)` / `isMock(array)` | Read the effective flags. |

## Next steps

- [Loggers](loggers.md)
- [Managers](managers.md)
