<?php

namespace Creode\LaravelNovaAssets\Services;

use Illuminate\Support\Facades\Storage;

class ZipExtractorService
{
    /**
     * Extracts the contents of a zip file into a single folder, collapsing the folder structure.
     *
     * @param  string  $zipPath  Path to the zip file.
     * @return array Array of extracted filepaths.
     */
    public function extractToCollapsedFolder($zipPath)
    {
        $zip = new \ZipArchive;
        $extractedFilePaths = [];
        if ($zip->open($zipPath) === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                // Load in the file from the zip folder and get details.
                $filename = $zip->getNameIndex($i);
                $fileinfo = pathinfo($filename);

                // Check if the file is valid.
                if (! $this->isValidFile($fileinfo)) {
                    continue;
                }

                // Handle duplicate filenames.
                $filePath = $fileinfo['basename'];
                if (Storage::disk(config('assets.disk', 'public'))->exists($fileinfo['basename'])) {
                    $filePath = $fileinfo['filename'].'-'.time().'.'.$fileinfo['extension'];
                }

                $success = Storage::disk(config('assets.disk', 'public'))->put(
                    $filePath,
                    file_get_contents('zip://'.$zipPath.'#'.$filename)
                );
                if (! $success) {
                    throw new \Exception('Failed to copy file from zip.');
                }
                $extractedFilePaths[] = Storage::disk(config('assets.disk', 'public'))->path($filePath);
            }
            $zip->close();
        }

        return $extractedFilePaths;
    }

    /**
     * Filters out any files we don't allow.
     *
     * @param  string|array{dirname:string, basename:string, extension:string, filename:string}  $fileinfo
     * @return bool True if file is valid, false if not.
     */
    public function isValidFile($fileinfo)
    {
        // If we can't get a file extension, it'll likely be a folder so we can ignore it.
        if (empty($fileinfo['extension'])) {
            return false;
        }

        // If file extension isn't in the accepted list, then ignore it.
        if (! in_array($fileinfo['extension'], config('nova-assets.accepted_zip_file_extensions'))) {
            return false;
        }

        // If file starts with ._ (these are often mac specific meta files that we don't need).
        if (substr($fileinfo['basename'], 0, 2) == '._') {
            return false;
        }

        return true;
    }
}
