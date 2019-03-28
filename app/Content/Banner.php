<?php

namespace Ulyssetour\Content;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    protected $fillable = ['title', 'sub_title', 'image', 'link', 'link_name', 'lang'];
}
