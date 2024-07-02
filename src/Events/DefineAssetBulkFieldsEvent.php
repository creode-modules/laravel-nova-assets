<?php

namespace Creode\LaravelNovaAssets\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Laravel\Nova\Fields\Field;

class DefineAssetBulkFieldsEvent
{
    use Dispatchable;

    /**
     * Array of Nova Fields.
     *
     * @param  Field[]  $fields
     */
    public function __construct(public array $fields = []) {}
}
