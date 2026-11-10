<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'disaster_id',
        'user_id',
        'title',
        'slug',
        'description',
        'target_amount',
        'collected_amount',
        'deadline',
        'status',
        'thumbnail',
    ];

    protected function casts(): array
    {
        return [
            'target_amount' => 'decimal:2',
            'collected_amount' => 'decimal:2',
            'deadline' => 'date',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function disaster(): BelongsTo
    {
        return $this->belongsTo(Disaster::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function verifiedDonations(): HasMany
    {
        return $this->hasMany(Donation::class)->where('status', 'verified');
    }

    /**
     * Menghitung persentase dana terkumpul (0 - 100%)
     */
    public function getProgressPercentageAttribute(): int
    {
        if ($this->target_amount <= 0) {
            return 0;
        }

        $percentage = ($this->collected_amount / $this->target_amount) * 100;
        return (int) min(100, round($percentage));
    }

    /**
     * Menghitung sisa hari penggalangan dana
     */
    public function getDaysRemainingAttribute(): ?int
    {
        if (!$this->deadline) {
            return null;
        }

        $diff = now()->startOfDay()->diffInDays($this->deadline->startOfDay(), false);
        return max(0, (int) $diff);
    }
}