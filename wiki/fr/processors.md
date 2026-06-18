# Processeurs Monolog

Deux petits processeurs **Monolog** qui ajoutent un marqueur visuel par niveau
dans les données `extra` de l'enregistrement, sous la clé `level_emoji`.
Attachez-les avec `pushProcessor()` et référencez `%extra.level_emoji%` (ou
`%extra%`) dans votre formateur.

## `EmojiProcessor`

`oihana\logging\monolog\processors\EmojiProcessor` associe un emoji à chaque
niveau.

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use oihana\logging\monolog\processors\EmojiProcessor;

$handler = new StreamHandler( 'php://stdout' );
$handler->setFormatter( new LineFormatter( "%extra.level_emoji% %message%\n" ) );

$logger = new Logger( 'app' );
$logger->pushProcessor( new EmojiProcessor() );
$logger->pushHandler( $handler );

$logger->warning( 'Espace disque faible' );
// ⚠ Espace disque faible
```

| Niveau | Emoji | Niveau | Emoji |
|---|---|---|---|
| Debug | 🐛 | Error | ❌ |
| Info | ℹ | Critical | 💥 |
| Notice | 📢 | Alert | 🚨 |
| Warning | ⚠ | Emergency | 🆘 |

## `SymbolProcessor`

`oihana\logging\monolog\processors\SymbolProcessor` associe un symbole compact à
chaque niveau et peut l'envelopper d'une **couleur ANSI** pour la sortie
terminal.

```php
use oihana\logging\monolog\processors\SymbolProcessor;

$logger->pushProcessor( new SymbolProcessor() );          // coloré (défaut)
$logger->pushProcessor( new SymbolProcessor( false ) );   // simple, sans couleurs ANSI
```

| Niveau | Symbole | Couleur | Niveau | Symbole | Couleur |
|---|---|---|---|---|---|
| Debug | `›` | gris | Error | `✘` | rouge |
| Info | `i` | vert | Critical | `⚡` | magenta |
| Notice | `※` | cyan | Alert | `‼` | rouge clair |
| Warning | `▲` | jaune | Emergency | `☢` | blanc sur rouge |

### Constructeur

```php
public function __construct( bool $useColors = true )
```

Passez `$useColors` à `false` lors de l'écriture dans un fichier ou une
destination qui ne doit pas contenir de codes d'échappement ANSI.

## Comment fonctionnent les processeurs

Un processeur Monolog est un `callable(LogRecord): LogRecord`. Les deux classes
ici sont des objets invocables : elles lisent `$record['level']`, recherchent le
marqueur, et l'écrivent dans `$record['extra']['level_emoji']` — sans toucher au
message d'origine. Le marqueur n'apparaît que si votre **formateur** affiche
`extra`.

## Étapes suivantes

- [Managers](managers.md) — `MonoLogManager` construit le logger Monolog auquel les attacher.
- [Énumérations](enums.md)
