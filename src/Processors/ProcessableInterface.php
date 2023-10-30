<?php

namespace Creode\LaravelNovaAssets\Processors;

use Illuminate\Support\Collection;

interface ProcessableInterface
{
    /**
     * Processes the data.
     */
    public function process(Collection $data): array;
}
