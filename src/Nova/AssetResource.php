<?php

namespace Creode\LaravelNovaAssets\Nova;

use Laravel\Nova\Resource;
use Creode\LaravelAssets\Models\Asset;
use DigitalCreative\Filepond\Filepond;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;
use Creode\LaravelNovaAssets\Events\DefineAssetFieldsEvent;
use Creode\LaravelNovaAssets\Events\DefineAssetActionsEvent;

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
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $defaultFields = [
            Filepond::make('Assets', 'location', config('assets.disk', 'public'))
                ->rules('required')
                ->mimesTypes(['image/*', 'application/pdf'])
                ->displayUsing(function ($value) {
                    return '<img src="https://picsum.photos/200/300" alt="Image" />';
                })
                ->store(function (NovaRequest $request, Model $model, string $attribute): array {
                    return [
                        $attribute => $request->location->store('/', ['disk' => config('assets.disk', 'public')]),
                        'name' => $request->location->getClientOriginalName(),
                        'size' => $request->location->getSize(),
                    ];
                }),
        ];

        // Trigger an event for adding fields.
        $event = new DefineAssetFieldsEvent($defaultFields);
        event($event);

        return $event->fields;
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        // Trigger an event for adding fields.
        $event = new DefineAssetActionsEvent(config('nova-assets.default_actions', []));
        event($event);

        return $event->actions;
    }
}
