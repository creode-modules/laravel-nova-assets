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
use Creode\LaravelNovaAssets\Notifications\UploadFailedNotification;

class AssetUploadJob implements ShouldQueue
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
    public function handle(AssetService $assetService): void
    {
        $success = Storage::disk(config('assets.disk'))
            ->put(
                $this->assetField['filename'],
                Storage::disk(config('nova-filepond.temp_disk'))
                    ->get($this->assetField['path']),
            );

        if (! $success) {
            throw new \Exception('Failed to copy file from temp disk.');
        }

        // Delete the old file.
        Storage::disk(config('nova-filepond.temp_disk'))->delete($this->assetField['path']);

        // Move the file.
        $uploadedAsset = $assetService->moveUploadedFile(
            Storage::disk(config('assets.disk'))->path($this->assetField['filename'])
        );

        // Create the database asset.
        $assetService->createAsset($uploadedAsset, $this->additionalFieldData);
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        $currentFile = $this->assetField['filename'];
        $this->userToNotify
            ->notify(
                new UploadFailedNotification(
                    "Failed to upload file: $currentFile. Please try again or send it to us directly for inspection."
                )
            );
    }
}
