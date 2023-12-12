<?php

namespace Creode\LaravelNovaAssets\Routes;

use Illuminate\Support\Facades\Route;
use Creode\LaravelNovaAssets\Http\Controllers\ThumbnailController;

Route::get('/generate/{asset:id}/thumbnail', ThumbnailController::class)->name('asset.generateThumbnail');
