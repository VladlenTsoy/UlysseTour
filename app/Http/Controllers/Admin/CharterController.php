<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ulyssetour\Content\Charter;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;

class CharterController extends Controller
{
    //
    public function all()
    {
        $charters = Charter::all();
        $langs = Language::all();
        $lang = Language::where('title', 'ru')->first();
        return view('admin.charter.all', ['charters' => $charters, 'langs' => $langs, 'lang' => $lang->data]);
    }

    //
    public function charterCreate()
    {
        $lang = Language::all();
        return view('admin.charter.create', ['lang' => $lang]);
    }


    //
    public function charterCreating(Request $request)
    {
        Charter::create($request->all());
        return redirect()->intended('/admin/charters');
    }


    //
    public function charterGetById($id)
    {
        $lang = Language::all();
        $charter = Charter::find($id);
        return view('admin.charter.edit', ['charter' => $charter, 'lang' => $lang]);
    }

    //
    public function charterEditById(Request $request, $id)
    {
        Charter::find($id)->update($request->all());
        return redirect()->intended('/admin/charters');
    }

    //
    public function charterDeleteById($id)
    {
        Charter::find($id)->delete();
        return redirect()->intended('/admin/charters');
    }
}
