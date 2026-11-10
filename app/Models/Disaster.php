<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'location',
        'latitude',
        'longitude',
        'impact_radius_km',
        'occurred_at',
        'status',
        'summary',
        'content',
        'thumbnail',
    ];

    protected function casts(): array
    {
        return [
            'occurred_at'      => 'datetime',
            'latitude'         => 'float',
            'longitude'        => 'float',
            'impact_radius_km' => 'float',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'siaga'           => 'Status Siaga',
            'tanggap_darurat' => 'Tanggap Darurat',
            'pemulihan'       => 'Masa Pemulihan',
            'selesai'         => 'Penanganan Selesai',
            default           => ucfirst($this->status),
        };
    }
}