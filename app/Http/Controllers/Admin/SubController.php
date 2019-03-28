<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;

class SubController extends Controller
{
    //
    /**
     *
     */
    public function selectAllTable($table)
    {
        $rows = DB::table($table)->get();
        $langForTitle = Language::where('title', 'ru')->first();
        $title = (array)$langForTitle->data;
        return view('admin.table.all', ['rows' => $rows, 'table' => $table, 'title' => $title[$table]]);
    }

    /**
     *
     */
    public function tableCreate($table)
    {
        $lang = Language::all();
        $langForTitle = Language::where('title', 'ru')->first();
        $title = (array)$langForTitle->data;
        return view('admin.table.create', ['table' => $table, 'lang' => $lang, 'title' => $title[$table]]);
    }

    /**
     *
     */
    public function tableCreating(Request $request, $table)
    {
        $title = $request->get('title');
        $lang = $request->get('lang');

        DB::table($table)->insert([
            'title' => $title,
            'lang' => $lang,
        ]);

        return redirect()->intended('/admin/' . $table);
    }

    /**
     *
     */
    public function tableGetById($table, $id)
    {
        $row = DB::table($table)
            ->where('id', $id)
            ->first();
        $langForTitle = Language::where('title', 'ru')->first();
        $title = (array)$langForTitle->data;
        $lang = Language::all();

        return view('admin.table.edit', ['table' => $table, 'row' => $row, 'lang' => $lang, 'title' => $title[$table]]);
    }

    /**
     *
     */
    public function tableEditById(Request $request, $table, $id)
    {
        $title = $request->get('title');
        $lang = $request->get('lang');

        DB::table($table)
            ->where('id', $id)
            ->update([
                'title' => $title,
                'lang' => $lang,
            ]);

        return redirect()->intended('/admin/' . $table);
    }

    /**
     *
     */
    public function tableDeleteById($table, $id)
    {
        DB::table($table)->where('id', $id)->delete();
        return redirect()->intended('/admin/' . $table);
    }

}
