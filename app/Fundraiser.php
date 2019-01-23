<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fundraiser extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('withRatingAverage', function ($builder) {
            $builder->withAvg('reviews as rating_avg', 'rating');
        });
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getRatingAvgAttribute($ratingAvg)
    {
        return round($ratingAvg, 1) ?? 0;
    }
}
