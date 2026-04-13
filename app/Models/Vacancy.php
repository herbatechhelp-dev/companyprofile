<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'division',
        'location',
        'type',
        'description',
        'requirements',
        'application_link',
        'is_active',
        'closing_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'closing_date' => 'date',
    ];

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vacancy) {
            if (!$vacancy->slug) {
                $vacancy->slug = \Illuminate\Support\Str::slug($vacancy->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->whereNull('closing_date')
                           ->orWhere('closing_date', '>=', now());
                     });
    }
}
