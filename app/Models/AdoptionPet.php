<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionPet extends Model
{
    protected $table = 'adoption_pets';

    protected $fillable = [
        'user_id', 'name', 'species', 'breed', 'age', 'gender', 'size',
        'color', 'description', 'health_status', 'vaccinated', 'neutered',
        'good_with_kids', 'good_with_pets', 'adoption_fee', 'image', 'is_adopted'
    ];

    protected $casts = [
        'vaccinated' => 'boolean',
        'neutered' => 'boolean',
        'good_with_kids' => 'boolean',
        'good_with_pets' => 'boolean',
        'is_adopted' => 'boolean',
        'adoption_fee' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}