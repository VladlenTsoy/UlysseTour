<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ulyssetour\Content\Helicopter;
use Ulyssetour\Content\Tour;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;

class HelicopterController extends Controller
{
    //
    public function all()
    {
        $helicopters = Helicopter::all();
        $langs = Language::all();
        $lang = Language::where('title', 'ru')->first();
        return view('admin.helicopter.all', ['helicopters' => $helicopters, 'langs' => $langs, 'lang' => $lang->data]);
    }

    //
    public function helicopterCreate()
    {
        $lang = Language::all();
        $tours = Tour::all();
        return view('admin.helicopter.create', ['lang' => $lang, 'tours' => $tours]);
    }


    //
    public function helicopterCreating(Request $request)
    {
        Helicopter::create($request->all());
        return redirect()->intended('/admin/helicopters');
    }


    //
    public function helicopterGetById($id)
    {
        $lang = Language::all();
        $tours = Tour::all();
        $helicopter = Helicopter::find($id);
        return view('admin.helicopter.edit', ['helicopter' => $helicopter, 'lang' => $lang, 'tours' => $tours]);
    }

    //
    public function helicopterEditById(Request $request, $id)
    {
        Helicopter::find($id)->update($request->all());
        return redirect()->intended('/admin/helicopters');
    }

    //
    public function helicopterDeleteById($id)
    {
        Helicopter::find($id)->delete();
        return redirect()->intended('/admin/helicopters');
    }
}
