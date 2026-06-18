# oihana/php-logging — Boîte à outils de journalisation PSR-3 pour PHP

![Langue](https://img.shields.io/badge/langue-Fran%C3%A7ais-blue)

`oihana/php-logging` est une bibliothèque PHP 8.4+ fournissant un petit ensemble de briques de journalisation **PSR-3** : un `Logger` autonome écrivant dans un fichier journalier, un `CompositeLogger` qui diffuse vers plusieurs loggers, un gestionnaire à fichiers tournants basé sur **Monolog**, trois traits composables, deux énumérations de configuration et deux processeurs Monolog.

![Oihana PHP Logging](https://raw.githubusercontent.com/BcommeBois/oihana-php-logging/main/assets/images/oihana-php-logging-logo-inline-512x160.png)

## À qui s'adresse cette documentation

Aux développeurs PHP qui veulent :

- écrire des lignes de log dans des **fichiers datés** sans dépendance externe — `oihana\logging\Logger` ;
- **diffuser** un même appel de log vers plusieurs loggers PSR-3 — `CompositeLogger` ;
- construire un logger **Monolog** à fichiers tournants depuis un simple tableau d'options — `MonoLogManager` ;
- ajouter la **journalisation PSR-3** à n'importe quelle classe via un trait — `LoggerTrait`, `DebugTrait` ;
- décorer les enregistrements Monolog d'un **emoji ou symbole** par niveau — `EmojiProcessor`, `SymbolProcessor`.

## Démarrage rapide

```php
use oihana\logging\Logger;

$logger = new Logger( __DIR__ . '/logs' , Logger::INFO ) ;

$logger->info( 'Application démarrée' ) ;
$logger->error( 'Connexion à {host} échouée' , [ 'host' => 'db-1' ] ) ;
// → logs/log_2026-06-18.log
```

Pour le détail complet (options, énumérations, contrats), voir la table des matières ci-dessous.

## Table des matières

### Démarrage — [`getting-started/`](getting-started/)

- [Introduction](getting-started/introduction.md) — ce que fait la bibliothèque et la philosophie *oihana*.
- [Installation](getting-started/installation.md) — prérequis PHP 8.4+ et `composer require`.
- [Dépendances](getting-started/dependencies.md) — Monolog, PHP-DI, les paquets `oihana/*` et leur rôle.

### Utilisation

- [Loggers](loggers.md) — `Logger` (fichier journalier, PSR-3) et `CompositeLogger` (diffusion).
- [Managers](managers.md) — `LoggerManager` (classe de base abstraite) et `MonoLogManager` (fabrique Monolog).
- [Traits](traits.md) — `LoggerTrait`, `LoggerManagerTrait`, `DebugTrait`.
- [Processeurs](processors.md) — `EmojiProcessor` et `SymbolProcessor` pour Monolog.
- [Énumérations](enums.md) — clés de configuration `LoggerParam`, `MonoLogParam`.

### Transversal

- [Tests & couverture](testing.md) — lancer la suite PHPUnit et mesurer la couverture.

## Code source

Le code de la bibliothèque se trouve sous [`src/oihana/logging/`](../../src/oihana/logging/) — espace de noms `oihana\logging`.

## Voir aussi

- [Packagist `oihana/php-logging`](https://packagist.org/packages/oihana/php-logging) — la page du paquet.
- [Référence API (phpDocumentor)](https://bcommebois.github.io/oihana-php-logging) — référence générée au niveau des classes.
