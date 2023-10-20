<?php

namespace Creode\LaravelNovaAssets\Commands;

use Illuminate\Console\Command;

class LaravelNovaAssetsCommand extends Command
{
    public $signature = 'laravel-nova-assets';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
