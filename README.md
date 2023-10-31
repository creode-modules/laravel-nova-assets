# Takes the existing Laravel Assets module and adds functionality to make it work in Nova.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/creode/laravel-nova-assets.svg?style=flat-square)](https://packagist.org/packages/creode/laravel-nova-assets)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/creode-modules/laravel-nova-assets/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/creode-modules/laravel-nova-assets/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/creode-modules/laravel-nova-assets/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/creode-modules/laravel-nova-assets/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/creode/laravel-nova-assets.svg?style=flat-square)](https://packagist.org/packages/creode/laravel-nova-assets)

Takes the existing Laravel Assets module and adds hookable functionality to make it work in Nova.

## Installation

You can install the package via composer:

```bash
composer require creode/laravel-nova-assets
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="nova-assets-config"
```

This is the contents of the published config file:

```php
use DigitalCreative\Filepond\Filepond;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;
use Creode\LaravelNovaAssets\Nova\Actions\BulkAssetUploadAction;

// config for Creode/LaravelNovaAssets
return [
    'default_fields' => [
        Filepond::make('Assets', 'location', config('assets.disk', 'public'))
            ->rules('required')
            ->mimesTypes(['image/*', 'application/pdf'])
            ->displayUsing(function ($value) {
                return '<img src="https://picsum.photos/200/300" alt="Image" />';
            })
            ->store(function (NovaRequest $request, Model $model, string $attribute): array {
                return [
                    $attribute => $request->location->store('/', ['disk' => config('assets.disk', 'public')]),
                    'name' => $request->location->getClientOriginalName(),
                    'size' => $request->location->getSize(),
                ];
            }),
    ],
    'default_bulk_fields' => [
        Filepond::make('Assets', 'location', config('assets.disk', 'public'))
            ->rules('required')
            ->multiple()
            ->mimesTypes(['image/*', 'application/zip', 'zip', 'application/pdf'])
    ],
    'default_actions' => [
        BulkAssetUploadAction::make()->standalone()
            ->onlyOnIndex()
            ->confirmButtonText('Upload')
            ->confirmText('Are you sure you want to upload these assets?')
            ->cancelButtonText('Cancel'),
    ],
];
```

There is a known configuration issue with these fields as it doesn't seem to render them correctly on the index page. Likely because they are not treated as different instances of the same field if they come from config.

## Usage
The purpose of this module is to use the existing assets model class and wrap it into a Nova resource. This allows us to use the existing functionality of the assets module in Nova. We use some hookable functionality which is documented below that gives any child modules the ability to add custom fields and actions to the resource.

### Registering Custom Resource Fields
You can register custom resource fields to appear in both the standard Nova pages (detail, edit, create) and the Bulk Asset Upload action. To do this you need to listen for the `DefineAssetFieldsEvent` event and add your fields to the `$fields` array. For a full list of Nova fields please look at the [Nova documentation](https://nova.laravel.com/docs/4.0/resources/fields.html).
    
```php
Event::listen(function (DefineAssetFieldsEvent $event) {
    $event->fields[] = Text::make('Folder', 'folder_id');
});
```

### Registering Custom Resource Actions
You can register custom resource actions to appear on the Asset resource. To do this you need to listen for the `DefineAssetActionsEvent` event and add your actions to the `$actions` array. These just use Nova's standard Actions functionality. For details about defining actions please look at the [Nova documentation](https://nova.laravel.com/docs/4.0/actions/defining-actions.html).

```php
Event::listen(function (DefineAssetActionsEvent $event) {
    $event->actions[] = TestActionClass::make();
});
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

- [Creode](https://github.com/creode)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
