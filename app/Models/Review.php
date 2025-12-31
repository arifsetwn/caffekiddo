<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    /**
     * Get the cafe that owns the review.
     */
    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }
}
