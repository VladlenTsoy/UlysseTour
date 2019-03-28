<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ulyssetour\Content\Guide;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;

class GuideController extends Controller
{
    //
    /**
     */
    public function guides()
    {
        $guides = Guide::all();
        return view('admin.guides.guides', ['guides' => $guides]);
    }

    /**
     */
    public function guideCreate()
    {
        $lang = Language::all();
        return view('admin.guides.create', ['lang' => $lang]);
    }

    /**
     */
    public function guideCreating(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $lang = $request->get('lang');

        Guide::create([
            'title' => $title,
            'description' => $description,
            'lang' => $lang,
        ]);
        return redirect()->intended('/admin/guides');
    }

    /**
     */
    public function guideGetById($id)
    {
        $guide = Guide::find($id);
        $lang = Language::all();
        return view('admin.guides.edit', ['guide' => $guide, 'lang' => $lang]);
    }

    /**
     */
    public function guideEditById(Request $request, $id)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $lang = $request->get('lang');

        Guide::find($id)->update([
            'title' => $title,
            'description' => $description,
            'lang' => $lang,
        ]);
        return redirect()->intended('/admin/guides');
    }

    /**
     */
    public function guideDeleteById($id)
    {
        Guide::find($id)->delete();
        return redirect()->intended('/admin/guides');
    }
}
