<?php

use Creode\LaravelAssets\Models\Asset;
use Creode\LaravelNovaAssets\Events\DefineAssetFieldsEvent;
use Creode\LaravelNovaAssets\Nova\AssetResource;
use Illuminate\Support\Facades\Event;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

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
