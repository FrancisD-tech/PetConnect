<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'user_id', 'name', 'breed', 'gender', 'age', 
        'image', 'status', 'microchip', 'vaccinated', 'neutered'
    ];

    protected $casts = [
        'vaccinated' => 'boolean',
        'neutered' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}