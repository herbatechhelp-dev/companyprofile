<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'image',
        'caption',
        'order',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
