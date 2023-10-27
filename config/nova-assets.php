<?php

use Creode\LaravelNovaAssets\Nova\Actions\BulkAssetUploadAction;
use DigitalCreative\Filepond\Filepond;

// config for Creode/LaravelNovaAssets
return [
    'default_fields' => [
        Filepond::make('Assets', 'location')
            ->rules('required')
            ->multiple()
            ->mimesTypes(['image/*'])
            ->default(fn () => []),
    ],
    'default_actions' => [
        BulkAssetUploadAction::make()->standalone(),
    ],
];
