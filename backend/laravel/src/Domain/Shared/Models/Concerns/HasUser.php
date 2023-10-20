<?php

namespace src\Domain\Shared\Models\Concerns;

use src\Domain\Shared\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use src\Domain\Shared\Models\User;

trait HasUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope());
    }
}
