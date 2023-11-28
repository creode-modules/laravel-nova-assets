<?php

namespace Creode\LaravelNovaAssets;

use Creode\LaravelNovaAssets\Http\Middleware\Authenticate;
use Creode\LaravelNovaAssets\Nova\AssetResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
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

        // Register the Model for the AssetResource and the AssetResource itself.
        AssetResource::$model = config('assets.asset_model');
        Nova::resources([
            AssetResource::class,
        ]);

        Nova::serving(function (ServingNova $event) {
            $this->registerPolicies();
        });

        $this->app->booted(function () {
            $this->routes();
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authenticate::class])
            ->prefix('assets')
            ->group(__DIR__.'/../routes/api.php');
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
        Gate::policy(config('assets.asset_model'), config('nova-assets.asset_policy'));
    }
}
