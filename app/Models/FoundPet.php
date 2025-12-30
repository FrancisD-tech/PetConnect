<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoundPet extends Model
{
    protected $fillable = [
        'user_id', 'species', 'breed', 'color', 'approximate_age', 'gender',
        'description', 'found_location', 'found_date', 'image',
        'contact_phone', 'is_claimed'
    ];

    protected $casts = [
        'found_date' => 'datetime',
        'is_claimed' => 'boolean',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDaysMissingAttribute()
    {
        return now()->diffInDays($this->lost_date);
    }
}
