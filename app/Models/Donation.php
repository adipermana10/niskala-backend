<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'invoice_number',
        'donor_name',
        'donor_email',
        'is_anonymous',
        'amount',
        'message',
        'payment_method',
        'status',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'amount' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Nama yang ditampilkan ke publik (menghormati privasi donatur anonim)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->is_anonymous ? 'Sahabat Niskala' : $this->donor_name;
    }
}