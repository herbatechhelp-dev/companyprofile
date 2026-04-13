<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'is_active',
        'sort_order',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
