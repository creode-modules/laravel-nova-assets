<?php

namespace Creode\LaravelNovaAssets;

use Creode\LaravelNovaAssets\Nova\AssetResource;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Events\ServingNova;
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

        Nova::serving(function (ServingNova $event) {
            $this->registerPolicies();
        });
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

    /**
     * Registers module policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return 'Creode\\LaravelNovaAssets\\Policies\\'.class_basename($modelClass).'Policy';
        });
    }
}
