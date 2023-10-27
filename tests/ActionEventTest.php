<?php

use Illuminate\Support\Facades\Event;
use Creode\LaravelAssets\Models\Asset;
use Laravel\Nova\Http\Requests\NovaRequest;
use Creode\LaravelNovaAssets\Nova\AssetResource;
use Creode\LaravelNovaAssets\Events\DefineAssetActionsEvent;
use Creode\LaravelNovaAssets\Tests\Mocks\Actions\TestAction;

it('allows actions to be added to nova', function () {
    Event::listen(function (DefineAssetActionsEvent $event) {
        $event->actions[] = TestAction::make();
    });

    $resource = new AssetResource(new Asset());
    $actions = $resource->actions(new NovaRequest());
    expect(
        collect($actions)->pluck('name')
    )->toContain('Test Action');
});
