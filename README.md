## Introduction

This is a simple Laravel Service Provider providing access to the [Alsaad PHP Client Library](https://github.com/AbdallaMohammed/alsaad-php).

## Installation

To install the PHP client library using Composer:

```
composer install abdallahmohammed/alsaad-laravel
```

Alternatively, add these two lines to your composer require section:

```json
{
    "require": {
        "abdallahmohammed/alsaad-laravel": "^1.0.0"
    }
}
```

#### Laravel 5.5+

If you're using Laravel 5.5 or above, the package will automatically register the Alsaad provider and facade.

#### Laravel 5.4 and below

Add `Alsaad\Laravel\AlsaadServiceProvider` to the providers array in your config/app.php:

```php
'providers' => [
    // Other service providers...
    Alsaad\Laravel\AlsaadServiceProvider::class,
],
```

If you want to use the facade interface, you can `use` the facade class when needed:

```php
use Alsaad\Laravel\Facade\Alsaad;
```

Or add an alias in your `config/app.php`:

```php
'aliases' => [
    ...
    'Alsaad' => Alsaad\Laravel\Facade\Alsaad::class,
],
```

#### Using with Lumen

alsaad-laravel works with Lumen too! You'll need to do a little work by hand to get it up and running. First, install the package using composer:

```text
composer install abdallahmohammed/alsaad-laravel
```

Next, we have to tell Lumen that our library exists. Update `bootstrap/app.php` and register the `AlsaadServiceProvider`:

```php
$app->register(Alsaad\Laravel\AlsaadServiceProvider::class);
```

Finally, we need to configure the library. Unfortunately Lumen doesn't support auto-publishing files so you'll have to create the config file yourself by creating a config directory and copying the config file out of the package in to your project:

```text
mkdir config
cp vendor/alsaad/laravel/config/alsaad.php config/alsaad.php
```

At this point, set `ALSAAD_USERNAME` and `ALSAAD_PASSWORD` in your `.env` file and it should be working for you. You can test this with the following route:

```php
$router->get('/', function () use ($router) {
    app(Alsaad\Client::class);
});
```

## Configuration

You can use `artisan vendor:publish` to copy the distribution configuration file to your app's config directory:

```text
php artisan vendor:publish
```

Then update `config/alsaad.php` with your credentials. Alternatively, you can update your `.env` file with the following:

```text
ALSAAD_USERNAME=my_username
ALSAAD_PASSWORD=my_password
```

## Usage

To use the Alsaad Client Library you can use the facade, or request the instance from the service container:

```php
Alsaad::message()->send([
    'to'   => '848393837',
    'from' => '438337393',
    'message' => 'Hello World'
]);
```

Or

```php
$nexmo = app('Alsaad\Client');

$nexmo->message()->send([
    'to'   => '848393837',
    'from' => '438337393',
    'message' => 'Hello World'
]);
```

For more information on using the Alsaad client library, see the [PHP Library](https://github.com/AbdallaMohammed/alsaad-php)
