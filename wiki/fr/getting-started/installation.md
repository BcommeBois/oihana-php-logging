# Installation

## Prérequis

- **PHP 8.4 ou supérieur.**
- **[Composer](https://getcomposer.org/).**

La bibliothèque elle-même n'exige aucune extension PHP particulière. La
dépendance transitive `oihana/php-files` (utilisée par `LoggerManager` pour la
découverte et la lecture de fichiers) requiert `ext-fileinfo`, `ext-openssl` et
`ext-zip`, présentes dans la plupart des distributions PHP.

## Installation via Composer

```bash
composer require oihana/php-logging
```

## Chargement automatique

Le paquet est chargé via PSR-4 :

```json
{
    "autoload": {
        "psr-4": {
            "oihana\\logging\\": "src/oihana/logging"
        }
    }
}
```

Une fois installé, importez directement les classes :

```php
use oihana\logging\Logger;
use oihana\logging\CompositeLogger;
use oihana\logging\MonoLogManager;
```

## Vérifier l'installation

```php
require 'vendor/autoload.php';

use oihana\logging\Logger;

$logger = new Logger( sys_get_temp_dir() . '/oihana-logs' );
$logger->info( 'Ça fonctionne !' );
```

## Étapes suivantes

- [Dépendances](dependencies.md)
- [Loggers](../loggers.md)
