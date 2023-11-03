<?php

namespace Creode\LaravelNovaAssets;

use Creode\LaravelNovaAssets\Nova\AssetResource;
use Laravel\Nova\Nova;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelNovaAssetsServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        parent::boot();

        // Publishes the permissions seeder.
        $this->publishes([
            __DIR__.'/../database/seeders/AssetRoleAndPermissionSeeder.php' => database_path('seeders/AssetRoleAndPermissionSeeder.php'),
        ], 'nova-assets-seeders');

        Nova::resources([
            AssetResource::class,
        ]);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-nova-assets')
            ->hasConfigFile()
            ->hasMigrations(['add_filepond_fields', 'add_filepond_mime_type_field'])
            ->runsMigrations();
    }
}
