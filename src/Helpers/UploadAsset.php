<?php

namespace Creode\LaravelNovaAssets\Helpers;

use Laravel\Nova\Makeable;

class UploadAsset
{
    use Makeable;

    /**
     * Constructor for File Class.
     *
     * @param  string  $relativePath  Relative path to the file (excluding disk path).
     * @param  string  $originalName  Original name of the uploaded file.
     * @param  int  $originalSize  Original Size of the uploaded file.
     * @param  string  $mimeType  Mime type of the uploaded file.
     */
    public function __construct(protected string $relativePath, protected string $originalName, protected int $originalSize, protected string $mimeType) {}

    /**
     * Gets the relative path to the file (excluding disk path).
     *
     * @return string
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * Gets the original name of the uploaded file.
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Gets the original Size of the uploaded file.
     *
     * @return int
     */
    public function getOriginalSize()
    {
        return $this->originalSize;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }
}
