<?php

namespace Mach3builders\PrivateLabel\Console;

use Illuminate\Console\Command;
use Mach3builders\PrivateLabel\Services\Forge;

class UpdateLabelPhp extends Command
{
    protected $signature = 'label:update-php';

    protected $description = 'Update the php version for all the websites';

    public function handle(Forge $forge)
    {
        $this->error('FIRST UPDATE THE PROJECT TO THE NEW PHP VERSION BEFORE RUNNING THIS COMMAND');
        $this->newLine();

        $this->line('This will help you update all the websites on the forge server to the chosen php version');
        $this->newLine();

        $this->info('Getting all php versions installed on the server');
        $this->newLine();

        $versions = $forge->phpVersions();

        $cli_version = array_values(array_filter($versions, function ($version) {
            return $version->usedOnCli;
        }));

        $default_version = array_values(array_filter($versions, function ($version) {
            return $version->usedAsDefault;
        }));

        $this->info('Current php version');

        $this->table(
            ['Cli', 'Default'],
            [
                [
                    $cli_version[0]->displayableVersion,
                    $default_version[0]->displayableVersion,
                ],
            ]
        );

        $chosen_version = $this->choice(
            'To what php version do you want to update all the websites?',
            array_map(fn ($v) => $v->version, $versions),
            0
        );

        if (! $this->confirm('Are you sure you want to update all the websites to the php version: '.$chosen_version.'?')) {
            $this->info('Aborting');

            return COMMAND::SUCCESS;
        }

        $this->line('Updating all the websites to the php version: '.$chosen_version);
        $this->line('Getting all the websites from the forge server');

        // get all websites from forge
        $sites = $forge->sites();
        $this->line('Found '.count($sites).' websites');

        // start bar progress
        $this->withProgressBar($sites, function ($site) use ($forge, $chosen_version) {
            $forge->changeSitePHPVersion($site->id, $chosen_version);
        });

        // Send done
        $this->newLine();
        $this->info('Updated '.count($sites).' websites to the php version: '.$chosen_version);

        $this->info('The script didnt update the php version for the server itself');
        $this->line('You need to do this manually');

        $this->line('Check all the deamons you have running');
        $this->line('Check all the crons you have running');
        return COMMAND::SUCCESS;
    }
}
