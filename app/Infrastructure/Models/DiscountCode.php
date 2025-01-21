<?php

namespace App\Infrastructure\Models;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'discount_code', 'code');
    }

    public function isValid(): bool
    {
        return !$this->is_used && $this->expires_at > now();
    }
}
