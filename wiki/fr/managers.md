# Managers

Un *manager* gère le cycle de vie des fichiers de log : où ils résident, comment
ils sont nommés, comment les lire/compter/vider, et comment construire le logger
PSR-3 réel.

## `LoggerManager` — classe de base abstraite

`oihana\logging\LoggerManager` est une classe abstraite fournissant des
utilitaires de gestion de fichiers autour d'un répertoire de logs. Les
sous-classes implémentent l'unique méthode abstraite `createLogger()`.

### Construction

```php
public function __construct( array $init = [] , ?string $name = null )
```

Le tableau `$init` est indexé par [`LoggerParam`](enums.md) :

| Clé (`LoggerParam::`) | Défaut | Signification |
|---|---|---|
| `DIRECTORY` | `''` | Répertoire de base des logs. |
| `PATH` | `''` | Sous-dossier dans le répertoire de base. |
| `EXTENSION` | `.log` | Extension des fichiers de log. |
| `DIR_PERMISSIONS` | `0775` | Permissions des répertoires créés. |

`$name` est le nom de canal optionnel, utilisé comme nom de base de fichier par défaut.

### API de gestion de fichiers

```php
$m->getDirectory() ;          // <directory>/<path>
$m->getFileName() ;           // <name> ou 'log'
$m->getExtension() ;          // '.log'
$m->getFilePath( $file ) ;    // chemin complet d'un fichier donné (ou par défaut)
$m->ensureDirectory() ;       // créer + vérifier l'écriture (lève DirectoryException)

$m->countLines( 'log_2026-06-18.log' ) ;   // int
$m->clear( 'log_2026-06-18.log' ) ;        // bool — vide le fichier
$m->getLoggerFiles() ;                      // string[] correspondant à '<name>*<extension>', triés asc
$m->getLogLines( null ) ;                   // analyse le fichier par défaut en entrées Log
$m->createLog( '2026-06-18 10:30:00 INFO Salut' ) ; // ?xyz\oihana\schema\Log
```

`createLog()` découpe une ligne en objet valeur `Log`
(`date`, `time`, `level`, `message`) ; il retourne `null` pour les lignes vides
ou mal formées.

### Écrire son propre manager

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

## `MonoLogManager` — fabrique Monolog à fichiers tournants

`oihana\logging\MonoLogManager` étend `LoggerManager` et construit un logger
**Monolog** entièrement configuré avec un `RotatingFileHandler` et un
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
$logger->info( 'Application démarrée' ) ;
```

`createLogger()` enregistre aussi le logger auprès du `ErrorHandler` de Monolog :
les erreurs PHP et exceptions non capturées sont donc interceptées
automatiquement.

### Options

Le tableau `$init` est indexé par [`MonoLogParam`](enums.md) :

| Clé (`MonoLogParam::`) | Défaut | Signification |
|---|---|---|
| `LEVEL` | `Level::Debug` | Niveau minimal (un `Monolog\Level` ou un entier). |
| `MAX_FILES` | `0` | Nombre de fichiers tournants conservés (`0` = tous). |
| `BUBBLES` | `true` | Si les enregistrements remontent vers d'autres handlers. |
| `FILE_PERMISSIONS` | `0664` | Permissions des fichiers de log créés. |
| `DATE_FORMAT` | `Y-m-d H:i:s` | Format de date dans chaque ligne. |
| `FORMAT` | `%datetime% %channel% %level_name% %message% %context% %extra%\n` | Format de ligne. |
| `ALLOW_INLINE_LINE_BREAKS` | `true` | Conserver les messages multi-lignes en ligne. |
| `IGNORE_EMPTY_CONTEXT_AND_EXTRA` | `true` | Ignorer `context`/`extra` vides. |
| `INCLUDE_STACK_TRACES` | `false` | Inclure les traces d'exception. |

Le `LineFormatter` est construit paresseusement et mis en cache ; récupérez-le
avec `getFormatter()`.

## Étapes suivantes

- [Processeurs](processors.md) — décorer les enregistrements Monolog par niveau.
- [Énumérations](enums.md) — les clés de configuration en détail.
