<?php

namespace Ulyssetour\Content;

use Illuminate\Database\Eloquent\Model;

class Charter extends Model
{
    //
    protected $fillable = ['route', 'cost', 'max_qty_tourists', 'lang'];
}
