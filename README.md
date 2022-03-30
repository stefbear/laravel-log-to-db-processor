# laravel-log-to-db-processor
Processor for Laravel 8 to facilitate comprehensive database logging for developers. DbLogProcessor uses IntrospectionProcessor to add dev info for *file, line, class, function* before writing the context to a database connection.

## Requirements

-   PHP 7.4
-   MySQL or compatible
-   Composer
-   Laravel 8

## Installation

Copy and paste folders into your project root directory. Update your laravel project's environment (.env) to include the following:

```shell
LOG_CHANNEL=custom
```

Run migrations:

```shell
php artisan migrate
```

Model and Controller included for reference.

## Usage

```php
use Illuminate\Support\Facades\Log;

Log::debug('User ID expected.');
Log::info('User deleted successfully.');
Log::warning('User not found.');
Log::error('Error deleting user.');
```