<?php

use DigitalCreative\Filepond\Filepond;
use Creode\LaravelNovaAssets\Nova\Actions\BulkAssetUploadAction;

// config for Creode/LaravelNovaAssets
return [
    'default_fields' => [
        Filepond::make('Assets', 'location')
            ->rules('required')
            ->multiple()
            ->mimesTypes(['image/*']),
    ],
    'default_actions' => [
        BulkAssetUploadAction::make()->standalone(),
    ],
];
