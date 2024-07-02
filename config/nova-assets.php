<?php

// config for Creode/LaravelNovaAssets
return [
    /*
    |--------------------------------------------------------------------------
    | Allowed Mime Types
    |--------------------------------------------------------------------------
    |
    | This value contains the allowed mime types for the module. You can add or
    | remove mime types as you wish.
    |
    */
    'allowed_mime_types' => [
        'image/*',
        'application/pdf',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Upload Accepted Mime Types
    |--------------------------------------------------------------------------
    |
    | This value contains the default bulk fields which will be rendered when
    | doing a bulk upload. You can add or remove fields as you wish.
    |
    */

    'default_upload_accepted_mime_types' => [
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

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | This value contains the image driver which will be used when generating
    | thumbnails. You can change this to your own driver if you wish. Drivers
    | must implement the Intervention\Image\Interfaces\DriverInterface
    | interface.
    |
    | This can be one of the following:
    | Intervention\Image\Drivers\Gd\Driver::class
    | Intervention\Image\Drivers\Imagick\Driver::class
    |
    */
    'image_driver' => Intervention\Image\Drivers\Gd\Driver::class,

    /*
    |--------------------------------------------------------------------------
    | Traffic Cop
    |--------------------------------------------------------------------------
    |
    | Indicates whether Nova should check for modifications between viewing
    | and updating a resource.
    |
    */
    'traffic_cop' => true,

    /*
    |--------------------------------------------------------------------------
    | Show Max Upload Size
    |--------------------------------------------------------------------------
    |
    | Indicates whether to show the max upload size in the asset resource.
    |
    */
    'show_max_upload_size' => false,
];
