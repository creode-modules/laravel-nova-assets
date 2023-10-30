<?php

namespace Creode\LaravelNovaAssets\Processors;

use Illuminate\Support\Collection;

interface ProcessableInterface
{
    /**
     * Processes the data.
     *
     * @param Collection $data
     * @return array
     */
    public function process(Collection $data): array;
}
