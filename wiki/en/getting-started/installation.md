# Installation

## Requirements

- **PHP 8.4 or higher.**
- **[Composer](https://getcomposer.org/).**

No special PHP extension is required by the library itself. The transitive
dependency `oihana/php-files` (used by `LoggerManager` for file discovery and
reading) requires `ext-fileinfo`, `ext-openssl` and `ext-zip`, which ship with
most PHP distributions.

## Install via Composer

```bash
composer require oihana/php-logging
```

## Autoloading

The package is autoloaded via PSR-4:

```json
{
    "autoload": {
        "psr-4": {
            "oihana\\logging\\": "src/oihana/logging"
        }
    }
}
```

Once installed, import the classes directly:

```php
use oihana\logging\Logger;
use oihana\logging\CompositeLogger;
use oihana\logging\MonoLogManager;
```

## Verify the installation

```php
require 'vendor/autoload.php';

use oihana\logging\Logger;

$logger = new Logger( sys_get_temp_dir() . '/oihana-logs' );
$logger->info( 'It works!' );
```

## Next steps

- [Dependencies](dependencies.md)
- [Loggers](../loggers.md)
