<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    /**
     * Get the user that owns the bookmark.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cafe that owns the bookmark.
     */
    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }
}
