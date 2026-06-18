# Monolog processors

Two small **Monolog** processors that add a per-level visual marker into the
record's `extra` data, under the key `level_emoji`. Attach them with
`pushProcessor()` and reference `%extra.level_emoji%` (or `%extra%`) in your
formatter.

## `EmojiProcessor`

`oihana\logging\monolog\processors\EmojiProcessor` maps each level to an emoji.

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

$logger->warning( 'Low disk space' );
// ⚠ Low disk space
```

| Level | Emoji | Level | Emoji |
|---|---|---|---|
| Debug | 🐛 | Error | ❌ |
| Info | ℹ | Critical | 💥 |
| Notice | 📢 | Alert | 🚨 |
| Warning | ⚠ | Emergency | 🆘 |

## `SymbolProcessor`

`oihana\logging\monolog\processors\SymbolProcessor` maps each level to a compact
symbol and can wrap it in an **ANSI color** for terminal output.

```php
use oihana\logging\monolog\processors\SymbolProcessor;

$logger->pushProcessor( new SymbolProcessor() );          // colored (default)
$logger->pushProcessor( new SymbolProcessor( false ) );   // plain, no ANSI colors
```

| Level | Symbol | Color | Level | Symbol | Color |
|---|---|---|---|---|---|
| Debug | `›` | grey | Error | `✘` | red |
| Info | `i` | green | Critical | `⚡` | magenta |
| Notice | `※` | cyan | Alert | `‼` | bright red |
| Warning | `▲` | yellow | Emergency | `☢` | white on red |

### Constructor

```php
public function __construct( bool $useColors = true )
```

Set `$useColors` to `false` when writing to a file or a destination that should
not contain ANSI escape codes.

## How processors work

A Monolog processor is any `callable(LogRecord): LogRecord`. Both classes here
are invokable objects: they read `$record['level']`, look up the marker, and
write it to `$record['extra']['level_emoji']` — leaving the original message
untouched. The marker only appears if your **formatter** prints `extra`.

## Next steps

- [Managers](managers.md) — `MonoLogManager` builds the Monolog logger you attach these to.
- [Enumerations](enums.md)
