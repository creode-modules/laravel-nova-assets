<?php

use Creode\LaravelNovaAssets\Nova\Actions\BulkAssetUploadAction;

// config for Creode/LaravelNovaAssets
return [

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
        BulkAssetUploadAction::make()
            ->standalone()
            ->confirmButtonText('Upload')
            ->confirmText('Are you sure you want to upload these assets?')
            ->cancelButtonText('Cancel')
            ->onlyOnIndex(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Bulk Upload Accepted Mime Types
    |--------------------------------------------------------------------------
    |
    | This value contains the default bulk fields which will be rendered when
    | doing a bulk upload. You can add or remove fields as you wish.
    |
    */

    'default_bulk_upload_accepted_mime_types' => [
        'image/*',
        'application/zip',
        'zip',
        'application/pdf',
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

    /*
    |--------------------------------------------------------------------------
    | Asset Policy
    |--------------------------------------------------------------------------
    |
    | This value contains the policy which will be used when verifying if a
    | user can perform an action on an asset. You can change this to your own
    | policy if you wish.
    |
    */

    'asset_policy' => \Creode\LaravelNovaAssets\Policies\AssetPolicy::class,
];
