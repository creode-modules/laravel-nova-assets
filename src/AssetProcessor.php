<?php

namespace Creode\LaravelNovaAssets;

use Illuminate\Support\Facades\Facade;
use Creode\LaravelNovaAssets\Processors\FilepondProcessor;

// @method array process()
class AssetProcessor extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return FilepondProcessor::class;
    }
}
