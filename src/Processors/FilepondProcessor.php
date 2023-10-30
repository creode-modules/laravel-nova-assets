<?php

namespace Creode\LaravelNovaAssets\Processors;

use Illuminate\Http\File;
use Illuminate\Support\Collection;
use DigitalCreative\Filepond\Data\Data;
use Illuminate\Support\Facades\Storage;

class FilepondProcessor implements ProcessableInterface
{
    /**
     * Converts an array of filepond server strings back into an array of Data objects.
     *
     * @param Collection $data
     * @return array
     */
    public function process(Collection $data): array
    {
        return $data->map(function ($item) {
            $data = Data::fromEncrypted($item);
            $fileBasePath = Storage::disk($data->disk)->path($data->path);

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            return [
                'path' => $data->path,
                'filename' => $data->filename,
                'disk' => $data->disk,
                'type' => $finfo->file($fileBasePath),
            ];
        })->toArray();
    }
}
