<?php

namespace Creode\LaravelNovaAssets;

use Creode\LaravelNovaAssets\Processors\FilepondProcessor;
use Illuminate\Support\Facades\Facade;

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
