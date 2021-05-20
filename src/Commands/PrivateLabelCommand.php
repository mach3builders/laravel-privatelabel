<?php

namespace Mach3builders\PrivateLabel\Commands;

use Illuminate\Console\Command;

class PrivateLabelCommand extends Command
{
    public $signature = 'laravel-privatelabel';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
