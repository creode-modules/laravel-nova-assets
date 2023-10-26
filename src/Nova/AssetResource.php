<?php

namespace Creode\LaravelNovaAssets\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\File;
use Creode\LaravelAssets\Models\Asset;
use Laravel\Nova\Http\Requests\NovaRequest;
use Creode\LaravelNovaAssets\Events\DefineAssetFieldsEvent;

class AssetResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Creode\LaravelAssets\Models\Asset>
     */
    public static $model = Asset::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $defaultFields = [
            ID::make()->sortable(),
            File::make('Asset', 'location'),
        ];

        // Trigger an event for adding fields.
        $event = new DefineAssetFieldsEvent($defaultFields);
        event($event);

        return $event->fields;
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
