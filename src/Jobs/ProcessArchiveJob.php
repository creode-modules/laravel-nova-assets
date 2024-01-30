<?php

namespace Creode\LaravelNovaAssets\Jobs;

use Throwable;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Auth\Authenticatable;
use Creode\LaravelNovaAssets\Services\AssetService;
use Creode\LaravelNovaAssets\Services\ZipExtractorService;
use Creode\LaravelNovaAssets\Notifications\UploadFailedNotification;

class ProcessArchiveJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  array  $fieldData
     */
    public function __construct(protected Authenticatable $userToNotify, public array $assetField, public array $additionalFieldData = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ZipExtractorService $zipExtractorService, AssetService $assetService): void
    {
        $zipPath = Storage::disk(config('nova-filepond.temp_disk'))->path($this->assetField['path']);

        // Load in the zip file.
        $extractedFiles = $zipExtractorService->extractToCollapsedFolder(
            $zipPath
        );

        // Loop through each file and create a new Asset model.
        foreach ($extractedFiles as $uploadedFilePath) {
            $uploadAsset = $assetService->moveUploadedFile($uploadedFilePath);
            $assetService->createAsset($uploadAsset, $this->additionalFieldData);
        }

        // Delete the zip file.
        unlink($zipPath);
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        $currentFile = $this->assetField['filename'];
        $this->userToNotify->notify(new UploadFailedNotification("Failed to unzip file: $currentFile. Please try again or send it to us directly for inspection."));
    }
}
