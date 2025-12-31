<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    /**
     * Get the cafes that have this facility.
     */
    public function cafes()
    {
        return $this->belongsToMany(Cafe::class, 'cafe_facility');
    }
}
