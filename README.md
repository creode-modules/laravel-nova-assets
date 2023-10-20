# Takes the existing Laravel Assets module and adds functionality to make it work in Nova.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/creode/laravel-nova-assets.svg?style=flat-square)](https://packagist.org/packages/creode/laravel-nova-assets)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/creode-modules/laravel-nova-assets/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/creode-modules/laravel-nova-assets/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/creode-modules/laravel-nova-assets/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/creode-modules/laravel-nova-assets/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/creode/laravel-nova-assets.svg?style=flat-square)](https://packagist.org/packages/creode/laravel-nova-assets)

Takes the existing Laravel Assets module and adds functionality to make it work in Nova.

## Installation

You can install the package via composer:

```bash
composer require creode/laravel-nova-assets
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-nova-assets-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-nova-assets-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-nova-assets-views"
```

## Usage

```php
$laravelNovaAssets = new Creode\LaravelNovaAssets();
echo $laravelNovaAssets->echoPhrase('Hello, Creode!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Creode](https://github.com/creode-modules)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
