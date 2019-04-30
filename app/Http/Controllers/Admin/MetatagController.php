<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\MetaTag;

class MetatagController extends Controller
{
    //
    public function all()
    {
        $tags = MetaTag::all();
        $langs = Language::all();
        return view('admin.tag.tags', ['tags' => $tags, 'langs' => $langs,]);
    }


    //
    public function сreate($lang)
    {
        $tags = MetaTag::where('lang', $lang)->get();
        $deftags = MetaTag::where('lang', 'ru')->whereNotIn('url', $tags->pluck('url'))->get();
        if ($deftags->count())
            return view('admin.tag.create', ['tags' => $tags, 'deftags' => $deftags, 'lang' => $lang]);
        else
            return redirect()->intended('/admin/tags');
    }

    //
    public function creating($lang, Request $request)
    {
        $data = $request->all();
        MetaTag::create([
            'url' => $data['url'],
            'title' => $data['title'],
            'user_url' => $data['user_url'],
            'description' => $data['description'],
            'lang' => $lang,
        ]);
        return redirect()->intended('/admin/tags');
    }

    //
    public function getById($id)
    {
        $tag = MetaTag::find($id);
        return view('admin.tag.edit', ['tag' => $tag]);
    }

    //
    public function editById(Request $request, $id)
    {
        $tag = MetaTag::find($id);
        $tag->title = $request->get('title');
        $tag->description = $request->get('description');
        $tag->user_url = $request->get('user_url');
        $tag->save();
        return redirect()->intended('/admin/tags');
    }
}
