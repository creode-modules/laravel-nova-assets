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
use Creode\LaravelNovaAssets\Nova\Actions\BulkAssetUploadAction;

// config for Creode/LaravelNovaAssets
return [

    /*
    |--------------------------------------------------------------------------
    | Default Actions
    |--------------------------------------------------------------------------
    |
    | This value contains the default actions which will be used when we managing
    | an asset resource. You can add or remove actions as you wish.
    |
    */

    'default_actions' => [
        BulkAssetUploadAction::make()
            ->standalone()
            ->confirmButtonText('Upload')
            ->confirmText('Are you sure you want to upload these assets?')
            ->cancelButtonText('Cancel')
            ->onlyOnIndex(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Bulk Upload Accepted Mime Types
    |--------------------------------------------------------------------------
    |
    | This value contains the default bulk fields which will be rendered when
    | doing a bulk upload. You can add or remove fields as you wish.
    |
    */

    'default_bulk_upload_accepted_mime_types' => [
        'image/*',
        'application/zip',
        'zip',
        'application/pdf',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Zip File Extensions
    |--------------------------------------------------------------------------
    |
    | This value contains an array of allowed file extensions which will be
    | pulled when extracting zip files during a bulk upload action.
    |
    */

    'accepted_zip_file_extensions' => [
        'png',
        'jpeg',
        'jpg',
        'webp',
        'pdf',
    ],
];
```

## Usage
The purpose of this module is to use the existing assets model class and wrap it into a Nova resource. This allows us to use the existing functionality of the assets module in Nova. We use some hookable functionality which is documented below that gives any child modules the ability to add custom fields and actions to the resource.

### Registering Custom Resource Fields
You can register custom resource fields to appear in both the standard Nova pages (detail, edit, create) and the Bulk Asset Upload action. To do this you need to listen for the `DefineAssetFieldsEvent` event and add your fields to the `$fields` array. For a full list of Nova fields please look at the [Nova documentation](https://nova.laravel.com/docs/4.0/resources/fields.html).
    
```php
Event::listen(function (DefineAssetFieldsEvent $event) {
    $event->fields[] = Text::make('Folder', 'folder_id');
});
```

### Registering Custom Resource Actions
You can register custom resource actions to appear on the Asset resource. To do this you need to listen for the `DefineAssetActionsEvent` event and add your actions to the `$actions` array. These just use Nova's standard Actions functionality. For details about defining actions please look at the [Nova documentation](https://nova.laravel.com/docs/4.0/actions/defining-actions.html).

```php
Event::listen(function (DefineAssetActionsEvent $event) {
    $event->actions[] = TestActionClass::make();
});
```

### Registering Custom Bulk Asset Fields
You can register custom bulk asset fields to appear on the Bulk Asset Upload action. To do this you need to listen for the `DefineBulkAssetFieldsEvent` event and add your fields to the `$fields` array. For a full list of Nova fields please look at the [Nova documentation](https://nova.laravel.com/docs/4.0/resources/fields.html).
    
```php
Event::listen(function (DefineBulkAssetFieldsEvent $event) {
    $event->fields[] = Text::make('Folder', 'folder_id');
});
```

### Insert a field after another one
As of version `1.4.0` of this module, you can now run a helper function to add an attribute in after another one. This can be done by running the following:
    
```php
Event::listen(function (DefineAssetFieldsEvent $event) {
    $event->addFieldAfter('name', Text::make('Folder', 'folder_id'));
});
```

This will then inject the field directly after the other. This is useful if you want to add a field after a specific field but don't want to have to worry about the order of the fields in the array. The only caveat here is that if the field with the provided first attribute doesn't exist, it will not add the field.

## Permissions
This module exposes a new permission seeder class which will need to be published to your application in order to grant permissions to the new resource. To do this you need to run the following command:

```bash
php artisan vendor:publish --tag="nova-assets-seeders"
```

This will create a new `AssetRoleAndPermissionSeeder.php` file within your `database/seeders` directory. This will need to be run in order to grant permissions to the new resource. You can run this by running the following command:

```bash
php artisan db:seed --class=AssetRoleAndPermissionSeeder
```

You should now see in your database a collection of permissions and a new role called `asset-manager`. This role will have all the permissions required to manage assets. Before running this, it requires the setup of any tables for the `spatie/laravel-permissions` package. Please see the [documentation](https://spatie.be/docs/laravel-permission/v6/installation-laravel) for more information.

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
