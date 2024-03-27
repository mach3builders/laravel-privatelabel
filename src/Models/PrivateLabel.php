<?php

namespace Mach3builders\PrivateLabel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mach3builders\PrivateLabel\Traits\HasStatus;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PrivateLabel extends Model implements HasMedia
{
    use HasFactory;
    use HasStatus;
    use InteractsWithMedia;

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

    public function getEmailDomainAttribute()
    {
        if (! $this->email) {
            return null;
        }

        return substr(strrchr($this->email, '@'), 1);
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
            'email_verified' => true,
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
