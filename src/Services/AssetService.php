<?php

namespace Creode\LaravelNovaAssets\Services;

use Creode\LaravelAssets\Models\Asset;
use Creode\LaravelNovaAssets\Helpers\UploadAsset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetService
{
    /**
     * Takes in required parameters and creates an asset.
     *
     * @param  UploadAsset  $asset
     * @return \Creode\LaravelAssets\Models\Asset
     */
    public function createAsset(UploadAsset $uploadAsset, array $fields)
    {
        $asset = new Asset();

        $asset->name = $uploadAsset->getOriginalName();
        $asset->size = $uploadAsset->getOriginalSize();
        $asset->location = $uploadAsset->getRelativePath();
        $asset->mime_type = $uploadAsset->getMimeType();

        foreach ($fields as $key => $fieldValue) {
            $asset->$key = $fieldValue;
        }

        $asset->save();

        return $asset;
    }

    /**
     * Moves the uploaded file to a location in-line with existing Filepond functionality.
     * Generates an uploaded asset type that can be used to create an asset.
     *
     * @param  string  $filePath Full path to the uploaded file.
     * @return UploadAsset
     */
    public function moveUploadedFile($filePath)
    {
        // Get the file info.
        $fileInfo = pathinfo($filePath);

        $newFilename = Str::random();
        $locationPath = $newFilename.'.'.$fileInfo['extension'];

        $oldPath = str_replace(
            Storage::disk(
                config('assets.disk', 'public')
            )->path(''),
            '',
            $filePath
        );

        // Move the file to the correct location.
        $moved = Storage::disk(config('assets.disk', 'public'))->move(
            $oldPath,
            $locationPath
        );

        if (! $moved) {
            throw new \Exception('Couldn\'t move file');
        }

        return UploadAsset::make(
            $locationPath,
            $fileInfo['basename'],
            Storage::disk(config('assets.disk', 'public'))->size($locationPath),
            Storage::disk(config('assets.disk', 'public'))->mimeType($locationPath)
        );
    }
}
