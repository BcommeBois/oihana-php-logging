# Dépendances

`oihana/php-logging` conserve volontairement une empreinte d'exécution réduite.
Voici ce dont elle a besoin et **pourquoi**.

## Dépendances d'exécution

| Paquet | Utilisé par | Rôle |
|---|---|---|
| [`psr/log`](https://packagist.org/packages/psr/log) | tout | Le contrat `LoggerInterface` que tous les composants implémentent ou consomment. |
| [`psr/container`](https://packagist.org/packages/psr/container) | `LoggerTrait`, `LoggerManagerTrait` | Conteneur PSR-11 pour résoudre un service logger/manager par identifiant. |
| [`monolog/monolog`](https://packagist.org/packages/monolog/monolog) | `MonoLogManager`, processeurs | Handler à fichiers tournants, formateur de ligne, `LogRecord` pour les processeurs. |
| [`php-di/php-di`](https://packagist.org/packages/php-di/php-di) | `LoggerTrait` | Exceptions DI remontées par les aides de résolution via conteneur. |
| [`oihana/php-core`](https://github.com/BcommeBois/oihana-php-core) | `Logger` | L'aide d'interpolation de chaînes `fastFormat()`. |
| [`oihana/php-enums`](https://github.com/BcommeBois/oihana-php-enums) | `Logger`, `LoggerManager` | Les énumérations `Char`, `Order`. |
| [`oihana/php-files`](https://github.com/BcommeBois/oihana-php-files) | `LoggerManager` | `findFiles`, `getFileLines`, `clearFile`, `countFileLines`, `joinPaths`. |
| [`oihana/php-reflect`](https://github.com/BcommeBois/oihana-php-reflect) | énumérations | `ConstantsTrait` (introspection des constantes). |
| [`oihana/php-schema`](https://github.com/BcommeBois/oihana-php-schema) | `LoggerManager::createLog()` | L'objet valeur `xyz\oihana\schema\Log` retourné lors de l'analyse d'une ligne de log. |
| [`oihana/php-traits`](https://github.com/BcommeBois/oihana-php-traits) | `Logger` | `ToStringTrait`. |

## Pourquoi si peu ?

La classe `Logger` est **autonome** : elle écrit dans des fichiers en PHP pur
(`fopen`/`fwrite`), de sorte qu'un projet n'ayant besoin que de journalisation
fichier ne paie presque rien. Monolog n'entre en jeu que lorsque vous
construisez réellement un `MonoLogManager` ou utilisez l'un des processeurs.

## Dépendances de développement

| Paquet | Rôle |
|---|---|
| `phpunit/phpunit` | Lanceur de tests (mode strict). |
| `nunomaduro/collision` | Sortie d'erreurs CLI lisible. |
| `mikey179/vfsstream` | Système de fichiers virtuel pour les tests de `LoggerManager`. |
| `phpdocumentor/shim` | Génération de la documentation API. |

## Étapes suivantes

- [Loggers](../loggers.md)
- [Managers](../managers.md)
