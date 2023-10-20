<?php

namespace Creode\LaravelNovaAssets;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Creode\LaravelNovaAssets\Commands\LaravelNovaAssetsCommand;

class LaravelNovaAssetsServiceProvider extends PackageServiceProvider
{
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
            ->hasViews()
            ->hasMigration('create_laravel-nova-assets_table')
            ->hasCommand(LaravelNovaAssetsCommand::class);
    }
}
