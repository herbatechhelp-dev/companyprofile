<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'sub_contents',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'sub_contents' => 'array',
        'is_active'    => 'boolean',
    ];
}
