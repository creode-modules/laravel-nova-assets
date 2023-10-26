<?php

namespace Creode\LaravelNovaAssets\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;
use Creode\LaravelNovaAssets\LaravelNovaAssetsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Creode\\LaravelNovaAssets\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelNovaAssetsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $this->createAssetsTable();
        $this->addFolderIdToAssetsTable();
    }

    /**
     * Creates assets table in database.
     */
    protected function createAssetsTable()
    {
        // Register Asset migration.
        $assetMigrationPath = $this->generateFolderPath([
            __DIR__,
            '..',
            'vendor',
            'creode',
            'laravel-assets',
            'database',
            'migrations',
        ]);
        $migration = include $assetMigrationPath . 'create_assets_table.php.stub';
        $migration->up();
    }

    /**
     * Adds to the assets table.
     */
    protected function addFolderIdToAssetsTable() {
        // Register migration for adding folder_id field.
        $folderIdMigrationPath = $this->generateFolderPath([
            __DIR__,
            'database',
            'migrations',
        ]);
        $migration = include $folderIdMigrationPath . 'add_asset_folder_field.php';
        $migration->up();
    }

    /**
     * Generate a path from an array of folders.
     *
     * @param array $folders
     * @return string The path.
     */
    private function generateFolderPath(array $folders): string
    {
        $path = '';

        foreach ($folders as $folder) {
            $path .= $folder . DIRECTORY_SEPARATOR;
        }

        return $path;
    }
}
