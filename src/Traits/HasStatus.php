<?php

namespace Mach3builders\PrivateLabel\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait HasStatus
{
    public function hasStatus(string $status): bool
    {
        return $this->status == $status;
    }

    public function completedStatus(string $status): bool
    {
        return array_search($status, $this->statusses) <= array_search($this->status, $this->statusses);
    }

    public function setStatus($name): void
    {
        $this->update(['status' => $name]);
    }

    public function scopeStatus(Builder $query, ...$names): mixed
    {
        $names = is_array($names) ? Arr::flatten($names) : func_get_args();

        $query->whereIn('status', $names);
    }
}
