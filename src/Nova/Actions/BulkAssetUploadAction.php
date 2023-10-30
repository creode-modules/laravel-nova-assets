<?php

namespace Creode\LaravelNovaAssets\Nova\Actions;

use Creode\LaravelNovaAssets\AssetProcessor;
use Creode\LaravelNovaAssets\Jobs\AssetUploadJob;
use Creode\LaravelNovaAssets\Jobs\ProcessArchiveJob;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class BulkAssetUploadAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $locationFields = AssetProcessor::process(collect($fields->get('location')));

        // Remove the location field from the list as we are already processing it.
        unset($fields['location']);

        // Build up a list of jobs.
        $jobsToProcess = [];

        // Batch them together and at the end trigger a notify job.
        foreach ($locationFields as $assetField) {
            // Detect the type.
            if ($assetField['type'] == 'application/zip' || $assetField['type'] == 'zip') {
                // If it's a zip, then run a ProcessArchiveJob.
                $jobsToProcess[] = new ProcessArchiveJob(Auth::user(), $assetField, $fields->toArray());

                continue;
            }

            $jobsToProcess[] = new AssetUploadJob($assetField, $fields->toArray());
        }

        $batch = Bus::batch($jobsToProcess)
            ->dispatch();

        return Action::message(
            __('Your uploaded assets are processing. We will send you an email once processing has completed!')
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return config('nova-assets.default_bulk_fields', []);
    }
}
