<?php

namespace Creode\LaravelNovaAssets\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Creode\LaravelAssets\Models\Asset;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Creode\LaravelNovaAssets\Services\AssetService;
use Creode\LaravelNovaAssets\Services\ZipExtractorService;

class AssetUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     *
     * @param array $fieldData
     */
    public function __construct(public array $assetField, public array $additionalFieldData = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(AssetService $assetService): void
    {
        $uploadedAsset = $assetService->moveUploadedFile($this->assetField['path']);
        $assetService->createAsset($uploadedAsset, $this->additionalFieldData);
    }
}
