<?php

namespace Creode\LaravelNovaAssets\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Creode\LaravelNovaAssets\LaravelNovaAssets
 */
class LaravelNovaAssets extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Creode\LaravelNovaAssets\LaravelNovaAssets::class;
    }
}
