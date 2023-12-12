<?php

namespace Creode\LaravelNovaAssets\Http\Controllers;

use Creode\LaravelAssets\Models\Asset;
use Creode\LaravelNovaAssets\Services\AssetService;
use Illuminate\Http\Response;

class ThumbnailController
{
    /**
     * Constructor for class.
     */
    public function __construct(protected AssetService $assetService)
    {
    }

    /**
     * Single function used to generate asset thumbnails.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $id)
    {
        $asset = Asset::findOrFail($id);
        if (! $asset->isImage($asset->mime_type)) {
            return response()->json(['message' => 'File is not an image'], 400);
        }

        $image = $this->assetService->generateThumbnail($asset);

        return (new Response($image))->header('Content-Type', 'image/webp');
    }
}
