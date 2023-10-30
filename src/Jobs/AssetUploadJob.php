<?php

namespace Creode\LaravelNovaAssets\Jobs;

use Creode\LaravelNovaAssets\Services\AssetService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssetUploadJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  array  $fieldData
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
