<?php

namespace Ulyssetour\Content;

use Illuminate\Database\Eloquent\Model;

class Helicopter extends Model
{
    //
    protected $fillable = [
        //
        'date',
        'title',
        'cost',
        'place',
        'max_qty_tourists',
        'lang'
    ];
}
