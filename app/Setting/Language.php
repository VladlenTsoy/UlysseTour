<?php

namespace Ulyssetour\Setting;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //
    protected $fillable = ['id', 'title', 'data', 'created_at', 'updated_at'];


    public function getDataAttribute($value)
    {

        if (gettype($value) === "string")
            return $this->attributes['data'] = json_decode($value);
        else
            return $value;
    }
}
