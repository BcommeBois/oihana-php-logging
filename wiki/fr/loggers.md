# Loggers

Deux implémentations de `Psr\Log\LoggerInterface` prêtes à l'emploi : un logger
fichier et un diffuseur.

## `Logger` — logger à fichier journalier

`oihana\logging\Logger` écrit les lignes de log dans un fichier nommé d'après le
jour courant, p. ex. `log_2026-06-18.log`, dans un répertoire de votre choix.

```php
use oihana\logging\Logger;

$logger = new Logger( __DIR__ . '/logs' , Logger::INFO ) ;

$logger->info( 'Utilisateur {id} connecté' , [ 'id' => 42 ] ) ;
$logger->error( 'Échec du paiement' ) ;
```

### Constructeur

```php
public function __construct( string $directory , int $level = Logger::DEBUG )
```

- `$directory` — le dossier où sont écrits les fichiers journaliers. Il est créé
  (récursivement, `0775`) s'il est absent.
- `$level` — la sévérité **minimale** à enregistrer. Utilisez les constantes
  ci-dessous.

### Niveaux de sévérité

| Constante | Valeur | Constante | Valeur |
|---|---|---|---|
| `Logger::EMERGENCY` | 0 | `Logger::NOTICE` | 5 |
| `Logger::ALERT` | 1 | `Logger::INFO` | 6 |
| `Logger::CRITICAL` | 2 | `Logger::DEBUG` | 7 |
| `Logger::ERROR` | 3 | `Logger::OFF` | 8 |
| `Logger::WARNING` | 4 | | |

Un message est écrit lorsque son niveau est **inférieur ou égal** au seuil
configuré (p. ex. avec `Logger::INFO` (6), `debug()` (7) est ignoré). Utilisez
`Logger::OFF` pour désactiver entièrement l'écriture fichier.

### Interpolation des messages

Les marqueurs de contexte écrits `{clé}` sont remplacés par la valeur de
contexte correspondante (scalaires et objets `Stringable` uniquement) :

```php
$logger->warning( 'Disque {name} à {pct} %' , [ 'name' => 'sda1' , 'pct' => 92 ] ) ;
// 2026-06-18 10:30:00 WARNING Disque sda1 à 92 %
```

### Personnaliser le nom de fichier

Trois propriétés publiques contrôlent le nom `{prefix}{date}{extension}` :

```php
$logger->prefix         = 'app_' ;   // défaut 'log_'
$logger->fileDateFormat = 'Y-m' ;    // défaut 'Y-m-d' (un fichier par mois)
$logger->extension      = '.txt' ;   // défaut '.log'
```

### Aides de maintenance & d'introspection

```php
$logger->getDirectory() ;   // le répertoire des logs
$logger->getPath() ;        // chemin complet du fichier du jour
$logger->getLogFiles() ;    // tous les noms de fichiers du répertoire
$logger->getStatus() ;      // Logger::STATUS_LOG_OPEN | STATUS_OPEN_FAILED | STATUS_LOG_CLOSED
$logger->getErrors() ;      // tampon interne de messages (diagnostics ouverture/permissions)
$logger->clear() ;          // supprime tous les fichiers de log du répertoire
$logger->writeFreeFormLine( 'ligne brute, sans horodatage' ) ;
```

### Crochets d'erreur / d'exception globales

`onError()` et `onException()` adaptent le logger aux gestionnaires globaux de PHP :

```php
set_error_handler    ( [ $logger , 'onError' ] ) ;
set_exception_handler( [ $logger , 'onException' ] ) ;
```

## `CompositeLogger` — diffuser vers plusieurs loggers

`oihana\logging\CompositeLogger` implémente `LoggerInterface` et transmet chaque
appel à chaque logger enregistré. Il stocke ses enfants dans une `WeakMap` : un
logger est donc **automatiquement retiré** dès qu'il n'est plus référencé
ailleurs.

```php
use oihana\logging\Logger;
use oihana\logging\CompositeLogger;

$composite = new CompositeLogger([
    new Logger( __DIR__ . '/logs' ) ,
    $monMonologLogger ,
]) ;

$composite->error( 'Diffusé vers chaque logger enregistré' ) ;
```

### API

```php
$composite->addLogger( $logger ) ;     // enregistrer (chaînable)
$composite->removeLogger( $logger ) ;  // retirer par référence (chaînable)
$composite->hasLogger( $logger ) ;     // bool
$composite->getLoggers() ;             // LoggerInterface[] encore vivants
$composite->clear() ;                  // tout retirer (chaînable)
$composite->count ;                    // nombre de loggers enregistrés (property hook)
```

## Étapes suivantes

- [Managers](managers.md) — construire un logger Monolog depuis des options.
- [Traits](traits.md) — ajouter la journalisation à vos propres classes.
