<?php

namespace Ulyssetour\Setting;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    //
    protected $fillable = ['url', 'title', 'description', 'user_url', 'lang'];
}
