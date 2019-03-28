<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;

class ServiceController extends Controller
{
    //

    /**  **/
    public function services($table)
    {
        $includes = DB::table($table)->get();
        $langForTitle = Language::where('title', 'ru')->first();
        $title = (array)$langForTitle->data;

        return view('admin.services.all', ['services' => $includes, 'table' => $table, 'title' => $title[$table]]);
    }

    /** **/
    public function serviceCreate($table)
    {
        $langForTitle = Language::where('title', 'ru')->first();
        $title = (array)$langForTitle->data;

        $lang = Language::all();
        return view('admin.services.create', ['lang' => $lang, 'title' => $title[$table], 'table' => $table]);
    }

    /** **/
    public function serviceCreating(Request $request, $table)
    {
        $title = $request->get('title');
        $description = $request->get('description') !== '' ?
            $request->get('description') : null;

        $lang = $request->get('lang');

        DB::table($table)->insert([
            'title' => $title,
            'description' => $description,
            'lang' => $lang,
        ]);
        return redirect()->intended('/admin/include/' . $table);
    }

    /**  **/
    public function serviceGetById($table, $id)
    {
        $langForTitle = Language::where('title', 'ru')->first();
        $title = (array)$langForTitle->data;

        $service = DB::table($table)->where('id', $id)->first();
        $lang = Language::all();

        return view('admin.services.edit', ['service' => $service, 'lang' => $lang, 'title' => $title[$table], 'table' => $table]);
    }

    /** **/
    public function serviceEditById($table, $id, Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description') !== '' ? $request->get('description') : null;
        $sub_category = null;

        if ($request->has('sub_category'))
            $sub_category = json_encode($request->get('sub_category'));

        $lang = $request->get('lang');

        DB::table($table)->where('id', $id)->update([
            'title' => $title,
            'description' => $description,
            'lang' => $lang,
        ]);
        return redirect()->intended('/admin/include/' . $table);
    }

    /** */
    public function serviceDeleteById($table, $id)
    {
        DB::table($table)->where('id', $id)->delete();
        return redirect()->intended('/admin/include/' . $table);
    }
}
