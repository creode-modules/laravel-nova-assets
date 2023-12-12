<?php

namespace Creode\LaravelNovaAssets\Routes;

use Creode\LaravelNovaAssets\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;

Route::get('/generate/{asset:id}/thumbnail', ThumbnailController::class)->name('asset.generateThumbnail');
