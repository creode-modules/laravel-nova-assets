<?php

namespace Creode\LaravelNovaAssets\Routes;

use Creode\LaravelAssets\Models\Asset;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as InterventionImage;

Route::get('/generate/{asset:id}/thumbnail', function ($id) {

    $asset = Asset::findOrFail($id);

    if (!$asset->isImage($asset->mime_type)) {
        return response()->json(['message' => 'File is not an image'], 400);
    }

    return InterventionImage::make($asset->path)
        ->crop(250, 250)
        ->response('png');
})->name('asset.generateThumbnail');
