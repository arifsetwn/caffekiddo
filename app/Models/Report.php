<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * Get the cafe that owns the report.
     */
    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    /**
     * Get the user that owns the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
