<?php

use Laravel\Nova\Fields\Text;
use Illuminate\Support\Facades\Event;
use Creode\LaravelAssets\Models\Asset;
use Laravel\Nova\Http\Requests\NovaRequest;
use Creode\LaravelNovaAssets\Nova\AssetResource;
use Creode\LaravelNovaAssets\Events\DefineAssetFieldsEvent;

it('allows fields to be added to nova', function () {
    Event::listen(function (DefineAssetFieldsEvent $event) {
        $event->fields[] = Text::make('Folder', 'folder_id');
    });

    $resource = new AssetResource(new Asset());
    $fields = $resource->fields(new NovaRequest());

    expect(
        collect($fields)->pluck('attribute')
    )->toContain('folder_id');
});
