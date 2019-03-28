<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\MetaTag;

class MetatagController extends Controller
{
    //
    public function all()
    {
        $tags = MetaTag::all();
        return view('admin.tag.tags', ['tags' => $tags]);
    }
}
