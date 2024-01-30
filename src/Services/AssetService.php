<?php

namespace Creode\LaravelNovaAssets\Services;

use Creode\LaravelAssets\Models\Asset;
use Creode\LaravelNovaAssets\Helpers\UploadAsset;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GDDriver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;

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
        $asset->disk = config('assets.disk', 'public');

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
     * @param  string  $filePath  Full path to the uploaded file.
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
            throw new \Exception('Couldn\'t move file from '.$oldPath.' to '.$locationPath.' on disk '.config('assets.disk', 'public').'.');
        }

        return UploadAsset::make(
            $locationPath,
            $fileInfo['basename'],
            Storage::disk(config('assets.disk', 'public'))->size($locationPath),
            Storage::disk(config('assets.disk', 'public'))->mimeType($locationPath)
        );
    }

    /**
     * Converts an asset into a thumbnail.
     */
    public function generateThumbnail(Asset $asset): EncodedImageInterface
    {
        // Build a cache for the image.
        $cacheKey = 'image-optimiser-'.md5($asset->url.'250x250');

        // If the image is not in the cache, generate it.
        if (! $image = Cache::get($cacheKey)) {
            $image = $this->processImage($asset);

            $oneWeekInMinutes = 60 * 24 * 7;
            Cache::put($cacheKey, $image, $oneWeekInMinutes);
        }

        return $image;
    }

    /**
     * Generates an image from an asset.
     */
    private function processImage(Asset $asset): EncodedImageInterface
    {
        // Build Image Manager
        $image = new ImageManager(config('nova-assets.image_driver', GDDriver::class));

        // If image is not in the cache, generate it.
        if (filter_var($asset->url, FILTER_VALIDATE_URL)) {
            $image = $image->read(file_get_contents($asset->url));
        } else {
            $image = $image->read($asset->url);
        }

        // Process the image.
        $image = $image->cover(250, 250, 'top-center');
        $image = $image->toWebp();

        return $image;
    }
}
