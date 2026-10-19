<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'title',
        'location',
        'description',
        'price',
        'available',
        'image',
        'owner_name',
        'owner_phone',
    ];

    // STEP 4: Ye method yahan add karo
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}