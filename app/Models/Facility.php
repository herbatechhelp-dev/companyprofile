<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'image',
        'location',
        'capacity',
        'features',
        'is_active',
        'order'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'capacity' => 'integer',
        'order' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facility) {
            if (empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });

        static::updating(function ($facility) {
            if ($facility->isDirty('name') && empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    /**
     * Get the first feature as a short description
     */
    public function getShortDescriptionAttribute()
    {
        if ($this->features && count($this->features) > 0) {
            return $this->features[0]['feature'] ?? 'No features';
        }
        return 'No features';
    }

    /**
     * Get featured facilities (you can customize this logic)
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    // Relasi ke FacilityImage
    public function images()
    {
        return $this->hasMany(FacilityImage::class)->orderBy('order');
    }
}