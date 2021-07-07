<?php

namespace Mach3builders\PrivateLabel\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateLabel extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'forge_site_id',
        'domain',
        'name',
        'email',
        'logo_login_height',
        'logo_app_height',
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
        return (bool) collect(dns_get_record($this->domain, DNS_CNAME))
            ->where('type', 'CNAME')
            ->where('target', config('private-label.domain'))
            ->count();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo_light')->singleFile();
        $this->addMediaCollection('logo_dark')->singleFile();
        $this->addMediaCollection('favicon')->singleFile();
    }
}
