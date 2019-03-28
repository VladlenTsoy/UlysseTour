<?php

namespace Ulyssetour\Content;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    //
    protected $fillable = [
        'title', 'description', 'url', 'meta_title', 'meta_description', 'created_at', 'updated_at', 'lang',
    ];

    /**
     * Читатель, добавленный к форме массива модели.
     *
     * @var array
     */
    protected $appends = ['min_description'];

    public function getMinDescriptionAttribute()
    {
        $description = $this->attributes['description'];

        // Strip HTML Tags
        $clear = strip_tags($description);
        // Clean up things like &amp;
        $clear = html_entity_decode($clear);
        // Strip out any url-encoded stuff
        $clear = urldecode($clear);
        // Replace non-AlNum characters with space
//        $clear = preg_replace('/[^A-Za-z0-9]/', ' ', $clear);
        // Replace Multiple spaces with single space
        $clear = preg_replace('/ +/', ' ', $clear);
        // Trim the string of leading/trailing space
        $clear = trim($clear);
        //
        $clear = mb_strimwidth($clear, 0, 250) . ' ...';

        return $this->attributes['min_description'] = $clear;
    }
}
