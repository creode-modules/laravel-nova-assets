<?php

namespace Creode\LaravelNovaAssets\Nova;

use Creode\LaravelAssets\Models\Asset;
use Creode\LaravelNovaAssets\Events\DefineAssetActionsEvent;
use Creode\LaravelNovaAssets\Events\DefineAssetFieldsEvent;
use Creode\MimeTypeAssetField\MimeTypeAssetField;
use DigitalCreative\Filepond\Filepond;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

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
     * Overwrites name (label) of resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Assets';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $defaultFields = [
            Text::make('Name')
                ->onlyOnIndex()
                ->sortable(),
            Filepond::make('Assets', 'location', config('assets.disk', 'public'))
                ->rules('required')
                ->mimesTypes(config('nova-assets.allowed_mime_types'))
                ->displayUsing(function ($value) {
                    return '<img src="https://picsum.photos/200/300" alt="Image" />';
                })
                ->store(function (NovaRequest $request, Model $model, string $attribute): array {
                    return [
                        $attribute => $request->location->store('/', ['disk' => config('assets.disk', 'public')]),
                        'name' => $request->location->getClientOriginalName(),
                        'size' => $request->location->getSize(),
                        'mime_type' => $request->location->getClientMimeType(),
                    ];
                })
                ->help(config('nova-assets.show_max_upload_size', false) ? 'Maximum File size is: '.ini_get('upload_max_filesize') : ''),
            MimeTypeAssetField::make('File', 'mime_type')
                ->onlyOnIndex()
                ->showOnIndex(function () {
                    return ! $this->resource->isImage($this->resource->mime_type);
                })
                ->sortable(),
            Image::make('File', 'location')
                ->indexWidth(40)
                ->textAlign('left')
                ->onlyOnIndex()
                ->showOnIndex(function () {
                    return $this->resource->isImage($this->resource->mime_type);
                })
                ->thumbnail(function () {
                    return route('asset.generateThumbnail', ['asset' => $this->resource->id]);
                })
                ->sortable(),
            DateTime::make('Created At')
                ->onlyOnIndex()
                ->sortable(),
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
