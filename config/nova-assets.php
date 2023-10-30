<?php

use Creode\LaravelNovaAssets\Nova\Actions\BulkAssetUploadAction;
use DigitalCreative\Filepond\Filepond;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;

// config for Creode/LaravelNovaAssets
return [
    /*
    |--------------------------------------------------------------------------
    | Default Fields
    |--------------------------------------------------------------------------
    |
    | This value contains the default fields which will be rendered when we
    | create a new asset resource. You can add or remove fields as you wish.
    |
    */

    'default_fields' => [
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
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Bulk Fields
    |--------------------------------------------------------------------------
    |
    | This value contains the default bulk fields which will be rendered when
    | doing a bulk upload. You can add or remove fields as you wish.
    |
    */

    'default_bulk_fields' => [
        Filepond::make('Assets', 'location', config('assets.disk', 'public'))
            ->rules('required')
            ->multiple()
            ->mimesTypes(['image/*', 'application/zip', 'zip', 'application/pdf']),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Actions
    |--------------------------------------------------------------------------
    |
    | This value contains the default actions which will be used when we managing
    | an asset resource. You can add or remove actions as you wish.
    |
    */

    'default_actions' => [
        BulkAssetUploadAction::make()->standalone()
            ->confirmButtonText('Upload')
            ->confirmText('Are you sure you want to upload these assets?')
            ->cancelButtonText('Cancel'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Zip File Extensions
    |--------------------------------------------------------------------------
    |
    | This value contains an array of allowed file extensions which will be
    | pulled when extracting zip files during a bulk upload action.
    |
    */

    'accepted_zip_file_extensions' => [
        'png',
        'jpeg',
        'jpg',
        'webp',
        'pdf',
    ],
];
