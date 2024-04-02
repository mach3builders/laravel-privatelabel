<?php

namespace Mach3builders\PrivateLabel\Services;

use Laravel\Forge\Forge as ForgeSDK;
use Mach3builders\PrivateLabel\Models\PrivateLabel;

class Forge
{
    private $forge;

    public function __construct(ForgeSDK $forge)
    {
        $this->forge = $forge;
    }

    public function createSite(PrivateLabel $private_label)
    {
        return $this->forge->setTimeout(300)->createSite(config('private-label.forge.server_id'), [
            'site_name' => $private_label->domain,
            'domain' => $private_label->domain,
            'project_type' => 'html',
            'directory' => '/public',
        ]);
    }

    public function updateNginx(PrivateLabel $private_label)
    {
        $content = $this->forge->siteNginxFile(config('private-label.forge.server_id'), $private_label->forge_site_id);

        $content = str_replace(
            'root /home/forge/'.$private_label->domain.'/public;',
            'root /home/forge/'.config('private-label.main_domain').'/public;',
            $content
        );

        $this->forge->updateSiteNginxFile(config('private-label.forge.server_id'), $private_label->forge_site_id, $content);
    }

    public function createCertificate(PrivateLabel $private_label)
    {
        $certificates = $this->forge->certificates(config('private-label.forge.server_id'), $private_label->forge_site_id);

        if (! $certificates) {
            $this->forge->setTimeout(300)->obtainLetsEncryptCertificate(
                config('private-label.forge.server_id'),
                $private_label->forge_site_id,
                ['domains' => [$private_label->domain]],
            );
        }
    }

    public function phpVersions()
    {
        return $this->forge->phpVersions(config('private-label.forge.server_id'));
    }

    public function sites()
    {
        return $this->forge->sites(config('private-label.forge.server_id'));
    }

    public function changeSitePHPVersion($site_id, $version)
    {
        $this->forge->setTimeout(300)->changeSitePHPVersion(config('private-label.forge.server_id'), $site_id, $version);
    }
}
