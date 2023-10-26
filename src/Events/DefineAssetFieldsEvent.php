<?php

namespace Creode\LaravelNovaAssets\Events;

use Laravel\Nova\Fields\Field;
use Illuminate\Foundation\Bus\Dispatchable;

class DefineAssetFieldsEvent
{
    use Dispatchable;

    /**
     * Array of Nova Fields.
     *
     * @param Field[] $fields
     */
    public function __construct(public array $fields)
    {
    }
}
