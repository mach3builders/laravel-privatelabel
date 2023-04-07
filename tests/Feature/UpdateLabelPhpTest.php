<?php

namespace Mach3builders\PrivateLabel\Tests\Unit;

use Mockery\MockInterface;
use Mach3builders\PrivateLabel\Services\Forge;
use Mach3builders\PrivateLabel\Tests\BaseTestCase;

class UpdateLabelPhpTest extends BaseTestCase
{
    /** @test */
    public function can_update_all_sites_for_a_server()
    {
        $this->mock(Forge::class, function (MockInterface $mock) {
            $mock->shouldReceive('phpVersions')
                ->once()
                ->andReturn([
                    (object) ['id' => 1, 'displayableVersion' => 'PHP 7.4', 'version' => '7.4', 'usedOnCli' => false, 'usedAsDefault' => false],
                    (object) ['id' => 2, 'displayableVersion' => 'PHP 8.0', 'version' => '8.0', 'usedOnCli' => true, 'usedAsDefault' => true],
                ])
                ->shouldReceive('sites')
                ->once()
                ->andReturn([
                    (object) ['id' => 1, 'name' => 'mach3builders.com', 'php_version' => '7.4'],
                    (object) ['id' => 2, 'name' => 'mach3builders.com', 'php_version' => '7.4'],
                ])
                ->shouldReceive('changeSitePHPVersion')
                ->once()
                ->with(1, '7.4')
                ->andReturn(true)
                ->shouldReceive('changeSitePHPVersion')
                ->once()
                ->with(2, '7.4')
                ->andReturn(true);
        });

        $this->artisan('label:update-php')
            ->expectsTable(['Cli', 'Default'], [
                ['PHP 8.0', 'PHP 8.0'],
            ])
            ->expectsQuestion('To what php version do you want to update all the websites?', '7.4')
            ->expectsConfirmation('Are you sure you want to update all the websites to the php version: 7.4?', 'yes')
            ->expectsOutput('Getting all the websites from the forge server')
            ->expectsOutput('Updated 2 websites to the php version: 7.4')
            ->expectsOutput('The script didnt update the php version for the server itself')
            ->expectsOutput('You need to do this manually')
            ->expectsOutput('Check all the deamons you have running')
            ->expectsOutput('Check all the crons you have running')
            ->assertExitCode(0);
    }

    /** @test */
    public function will_ask_user_if_sure_to_update_all_websites()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function will_update_all_websites_to_new_php_version()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function will_send_done_message()
    {
        $this->markTestIncomplete();
    }
}
