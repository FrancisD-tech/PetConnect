<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionPet extends Model
{
    protected $table = 'adoptable_pets';

    protected $fillable = [
        'name',
        //'species',
        'breed',
        'age_months',
        'gender',
        'location',
        'description',
        'image_main',
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