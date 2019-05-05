<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;

class LanguageController extends Controller
{
    //
    // Языки
    public function languages()
    {
        $languages = Language::all();
        return view('admin.languages.all', ['languages' => $languages]);
    }

    // Добавить язык
    public function languageCreate()
    {
        $langs = Language::all();
        $languages = Language::where('title', 'ru')->first();
        return view('admin.languages.create', ['languages' => $languages, 'lang' => $langs]);
    }

    //
    public function languageCreating(Request $request)
    {
        $reqData = $request->all();
        $mainData = [];
        $pluses = [];
        $lang = '';

        foreach ($reqData['pluses_title'] as $key => $title)
            array_push($pluses, ['title' => $title, 'description' => $reqData['pluses_description'][$key]]);

        foreach ($reqData as $key => $val) {
            if ($key === '_token') {
            } elseif ($key === 'pluses_title' || $key === 'pluses_description') {
            } elseif ($key === 'lang') {
                $lang = $val;
            } else
                $mainData[$key] = $val;
        }

        $mainData['pluses'] = $pluses;
        Language::create(['data' => json_encode($mainData), 'title' => $lang]);
        return redirect()->intended('/admin/languages/');
    }

    // Добавить язык
    public function languageGetById($id)
    {
        $langs = Language::all();
        $def_language = Language::find(1);
        $languages = Language::find($id);

        return view('admin.languages.edit', [
            'id' => $id,
            'languages' => $languages,
            'def_language' => $def_language,
            'lang' => $langs
        ]);
    }

    //
    public function languageEditById(Request $request, $id)
    {
        $reqData = $request->all();
        $mainData = [];
        $pluses = [];
        $lang = '';

        foreach ($reqData['pluses_title'] as $key => $title)
            array_push($pluses, ['title' => $title, 'description' => $reqData['pluses_description'][$key]]);

        foreach ($reqData as $key => $val) {
            if ($key === '_token') {
            } elseif ($key === 'pluses_title' || $key === 'pluses_description') {
            } elseif ($key === 'lang') {
                $lang = $val;
            } else
                $mainData[$key] = $val;
        }

        $mainData['pluses'] = $pluses;
        Language::find($id)->update(['data' => json_encode($mainData), 'title' => $lang]);
        return redirect()->intended('/admin/languages/');
    }

    /**
     *
     */
    public function languageDeleteById($id)
    {
        Language::find($id)->delete();
        return redirect()->intended('/admin/languages');
    }

    /*
     *
     */
    public function default()
    {
        $lang = Language::def();
        return response()->json($lang);
    }
}
