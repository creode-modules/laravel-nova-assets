<?php

namespace Creode\LaravelNovaAssets\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Laravel\Nova\Actions\Action;

class DefineAssetActionsEvent
{
    use Dispatchable;

    /**
     * Array of Nova Actions.
     *
     * @param  Action[]  $actions
     */
    public function __construct(public array $actions = []) {}
}
