<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostPet extends Model
{
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
