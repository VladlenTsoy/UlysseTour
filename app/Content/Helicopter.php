<?php

namespace Ulyssetour\Content;

use Illuminate\Database\Eloquent\Model;

class Helicopter extends Model
{
    //
    protected $fillable = [
        //
        'category',
        'date',
        'title',
        'cost',
        'place',
        'max_qty_tourists',
        'tour_id',
        'lang'
    ];

    protected $appends = [
        'tour_url'
    ];

    public function getTourUrlAttribute()
    {
        $tour = Tour::find($this->attributes['tour_id']);
        return $tour ? $tour['url'] : null;
    }
}
