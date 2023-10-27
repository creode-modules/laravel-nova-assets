<?php

namespace Creode\LaravelNovaAssets\Events;

use Laravel\Nova\Actions\Action;
use Illuminate\Foundation\Bus\Dispatchable;

class DefineAssetActionsEvent
{
    use Dispatchable;

    /**
     * Array of Nova Actions.
     *
     * @param Action[] $actions
     */
    public function __construct(public array $actions = [])
    {
    }
}
