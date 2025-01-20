<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscountCode extends Model
{
    protected $table = 'discount_codes';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'code',
        'amount',
        'user_id',
        'expires_at',
        'is_used',
        'used_at'
    ];

    protected $casts = [
        'id' => 'string',
        'amount' => 'float',
        'is_used' => 'boolean',
        'expires_at' => 'datetime',
        'used_at' => 'datetime'
    ];

    protected $attributes = [
        'is_used' => false
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'discount_code', 'code');
    }

    // Scopes
    public function scopeValid(Builder $query): Builder
    {
        return $query->where('is_used', false)
            ->where('expires_at', '>', now());
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopeUsed(Builder $query): Builder
    {
        return $query->where('is_used', true);
    }

    public function scopeForUser(Builder $query, string $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByCode(Builder $query, string $code): Builder
    {
        return $query->where('code', $code);
    }


    // Helper Methods
    public function isValid(): bool
    {
        return !$this->is_used && $this->expires_at > now();
    }

    public function isExpired(): bool
    {
        return $this->expires_at <= now();
    }

    public function markAsUsed(): bool
    {
        if ($this->is_used) {
            return false;
        }

        return $this->update([
            'is_used' => true,
            'used_at' => now()
        ]);
    }
}
