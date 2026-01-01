<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LostPet extends Model
{
    protected $fillable = [
        'user_id',
        'pet_name',   
        'species',        
        'breed',
        'color',
        'age',
        'gender',
        'description',        
        'last_seen_location', 'lat', 'lng', 
        'lost_date',  
        'contact_phone',       
        'image',
        'is_reunited',
        'status',
        'reunited_at',
    ];

    protected $casts = [
        'lost_date' => 'date',
        'is_reunited' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fixed accessor
    public function getDaysMissingAttribute()
    {
        return $this->lost_date->diffInDays(now());
    }
}
