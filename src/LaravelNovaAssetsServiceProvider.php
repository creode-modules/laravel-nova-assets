<?php

namespace Creode\LaravelNovaAssets;

use Laravel\Nova\Nova;
use Spatie\LaravelPackageTools\Package;
use Creode\LaravelNovaAssets\Nova\AssetResource;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelNovaAssetsServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
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
            ->hasConfigFile();
    }
}
