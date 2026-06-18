# Traits

Trois traits composables pour apporter des capacités de journalisation à vos
propres classes, chacun avec une responsabilité unique.

## `LoggerTrait` — journalisation PSR-3 pour toute classe

`oihana\logging\LoggerTrait` s'appuie sur `Psr\Log\LoggerAwareTrait` et expose
toutes les méthodes de niveau PSR-3 (`emergency()` … `debug()`), toutes
protégées par un appel *null-safe* — elles sont donc des no-op sûres tant
qu'aucun logger n'est défini.

```php
use oihana\logging\LoggerTrait;
use Psr\Log\LoggerInterface;

class MonService
{
    use LoggerTrait;

    public function __construct( ?LoggerInterface $logger = null )
    {
        $this->initializeLogger( $logger );
    }

    public function run(): void
    {
        $this->info( 'Service démarré' );
    }
}
```

### Constantes & état

| Membre | Signification |
|---|---|
| `LoggerTrait::LOGGER` (`'logger'`) | Clé de tableau pour lire un logger depuis un tableau d'init. |
| `LoggerTrait::LOGGABLE` (`'loggable'`) | Clé de tableau/conteneur utilisée par `initializeLoggable()`. |
| `bool $loggable` | Un drapeau que vous pouvez vérifier avant de journaliser. |

### `initializeLogger()`

```php
public function initializeLogger(
    array|LoggerInterface|string|null $init = null ,
    ?ContainerInterface               $container = null ,
    bool                              $useDefault = true
) : static
```

Accepte :

- une instance de **`LoggerInterface`** → utilisée directement ;
- un **tableau** contenant le logger sous la clé `LOGGER` ;
- une **chaîne** identifiant de service / nom de classe → résolue depuis `$container` ;
- **`null`** → lorsque `$useDefault` vaut `true` (le défaut), se rabat sur la
  résolution de `LoggerInterface::class` depuis le conteneur.

Si rien ne se résout en `LoggerInterface`, `$this->logger` est mis à `null` (et
les méthodes de niveau deviennent des no-op).

```php
$service->initializeLogger( 'my-logger' , $container ) ;          // par identifiant de service
$service->initializeLogger( [ 'logger' => $psrLogger ] ) ;        // depuis un tableau
$service->initializeLogger( null , $container ) ;                 // service par défaut
```

### `initializeLoggable()`

```php
public function initializeLoggable(
    bool|array|null     $init = null ,
    ?ContainerInterface $container = null ,
    bool                $defaultValue = false
) : static
```

Définit le drapeau `$loggable` depuis un booléen, un tableau (clé `LOGGABLE`),
ou une entrée de conteneur nommée `loggable`.

## `LoggerManagerTrait` — injecter un `LoggerManager`

`oihana\logging\LoggerManagerTrait` ajoute une propriété
`?LoggerManager $manager` et un résolveur.

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
accepte une instance, ou un identifiant de service résolu depuis le conteneur ;
toute autre valeur laisse `$manager` à `null`.

## `DebugTrait` — drapeaux debug & mock

`oihana\logging\DebugTrait` **utilise `LoggerTrait`** et ajoute deux modes
booléens : `debug` et `mock`. Le mode mock n'est actif que si le mode debug
l'est aussi.

```php
use oihana\logging\DebugTrait;

class MonService
{
    use DebugTrait;
}

$service = ( new MonService() )
    ->initializeDebug([ DebugTrait::DEBUG => true ])
    ->initializeMock ([ DebugTrait::MOCK  => true ]);

$service->isDebug(); // true
$service->isMock();  // true  (serait false si debug était désactivé)
```

| Membre | Signification |
|---|---|
| `DebugTrait::DEBUG` (`'debug'`) / `bool $debug` | Clé et drapeau du mode debug. |
| `DebugTrait::MOCK` (`'mock'`) / `bool $mock` | Clé et drapeau du mode mock. |
| `initializeDebug(array, bool)` / `initializeMock(array, bool)` | Définit les drapeaux (les valeurs non booléennes se rabattent sur le défaut). |
| `isDebug(array)` / `isMock(array)` | Lit les drapeaux effectifs. |

## Étapes suivantes

- [Loggers](loggers.md)
- [Managers](managers.md)
