<?php

namespace Mach3builders\PrivateLabel\Console;

use Illuminate\Console\Command;
use Mach3builders\PrivateLabel\Jobs\InstallSite;
use Mach3builders\PrivateLabel\Models\PrivateLabel;

class Reinstall extends Command
{
    protected $signature = 'label:reinstall {--label=}';

    protected $description = 'Reinstall all or specific private labels.';

    public function handle()
    {
        $id = $this->option('label');

        $labels = PrivateLabel::query()
            ->when($id, fn ($query) => $query->where('id', $id))
            ->get();

        if (! $labels) {
            $this->error('No labels found.');

            return;
        }

        $this->withProgressBar($labels, function ($label) {
            $label->update([
                'status' => 'dns_validating',
            ]);

            InstallSite::dispatch($label);
        });
    }
}
