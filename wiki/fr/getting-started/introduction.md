# Introduction

`oihana/php-logging` rassemble les briques de journalisation qui vivaient auparavant dans `oihana/php-system`, extraites dans un paquet ciblé et léger, afin qu'un projet puisse dépendre de la journalisation **sans** tirer une pile HTTP, un moteur de templates ou une couche base de données.

Tout est bâti autour du standard **PSR-3** (`Psr\Log\LoggerInterface`), de sorte que les composants interopèrent avec n'importe quel producteur ou consommateur PSR-3 (Symfony, Laravel, handlers Monolog, etc.).

## Ce qu'elle fournit

| Composant | Type | Rôle |
|---|---|---|
| `Logger` | classe | Logger PSR-3 autonome écrivant dans un fichier journalier (sans dépendance externe). |
| `CompositeLogger` | classe | Diffuse chaque appel de log vers plusieurs loggers PSR-3 (basé sur `WeakMap`). |
| `LoggerManager` | classe abstraite | Classe de base pour gérer les fichiers de log (lire, compter, vider, lister, analyser). |
| `MonoLogManager` | classe | Construit un logger **Monolog** à fichiers tournants depuis un tableau d'options. |
| `LoggerTrait` | trait | Ajoute la journalisation PSR-3 à toute classe, avec résolution via conteneur DI. |
| `LoggerManagerTrait` | trait | Injecte un `LoggerManager` dans toute classe. |
| `DebugTrait` | trait | Ajoute les drapeaux `debug` / `mock` par-dessus `LoggerTrait`. |
| `EmojiProcessor` / `SymbolProcessor` | classes | Processeurs Monolog décorant les enregistrements par niveau. |
| `LoggerParam` / `MonoLogParam` | énumérations | Clés de configuration fortement typées (pas de *magic strings*). |

## La philosophie *oihana*

- **PHP 8.4+ uniquement** — constantes typées, *property hooks*, `WeakMap`, aucun palliatif hérité.
- **Pas de *magic strings*** — chaque clé de configuration est une constante typée dans une énumération (`LoggerParam`, `MonoLogParam`).
- **Composable** — chaque trait a une responsabilité unique et se combine librement.
- **Testé** — 100 % de couverture de lignes, mode strict PHPUnit (voir [Tests & couverture](../testing.md)).

## Étapes suivantes

- [Installation](installation.md)
- [Dépendances](dependencies.md)
- [Loggers](../loggers.md)
