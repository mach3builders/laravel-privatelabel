<?php

namespace Mach3builders\PrivateLabel\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Mach3builders\PrivateLabel\Traits\HasStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateLabel extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasStatus;

    protected $fillable = [
        'forge_site_id',
        'domain',
        'name',
        'email',
        'logo_login_height',
        'logo_app_height',
        'email_verified',
        'status',
    ];

    protected $statusses = [
        'dns_validating',
        'dns_validated',
        'site_installing',
        'site_installed',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(config('private-label.owner_model'), 'owner_id', 'id');
    }

    public function checkDns(): bool
    {
        if ($this->status != 'dns_validating') {
            return true;
        }

        return (bool) collect(dns_get_record($this->domain, DNS_CNAME))
            ->where('type', 'CNAME')
            ->where('target', config('private-label.domain'))
            ->count();
    }

    public function setEmailVerified()
    {
        $this->update([
            'email_verified' => true
        ]);

        \Mach3builders\PrivateLabel\Events\EmailDomainVerified::dispatch($this);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo_light')->singleFile();
        $this->addMediaCollection('logo_dark')->singleFile();
        $this->addMediaCollection('favicon')->singleFile();
    }
}
