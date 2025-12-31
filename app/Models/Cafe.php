<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cafe extends Model
{
    /**
     * Get the user who submitted the cafe.
     */
    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /**
     * Get the facilities for the cafe.
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'cafe_facility');
    }

    /**
     * Get the reviews for the cafe.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the bookmarks for the cafe.
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get the reports for the cafe.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Scope a query to only include active cafes.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the average rating for the cafe.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('status', 'approved')->avg('rating');
    }
}
