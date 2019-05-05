<?php

namespace Ulyssetour\Http\Controllers;

use Illuminate\Support\Facades\Lang;
use Ulyssetour\Content\Banner;
use Ulyssetour\Content\Tour;
use Ulyssetour\Setting\Language;

class HomeController extends Controller
{
    public function index($lang = false)
    {
        if (!$lang) return redirect('/en');
        $this->updateLanguage($lang);
        $language = Language::where('title', $lang)->first();

        $banners = Banner::where('lang', $language->title)->get();
        $sATours = Tour::where(['lang' => $language->title, 'country' => 0, 'hot' => null])->latest()->limit(3)->get();
        $uzTours = Tour::where(['lang' => $language->title, 'country' => 1, 'hot' => null])->latest()->limit(3)->get();
        $hotTours = Tour::where([['lang', '=', $language->title], ['hot', '>', date("Y-m-d")]])->orderBy('hot')->get();

        $setting = [
            'title' => $language->data->title_site,
            'description' => $language->data->description_site,
        ];

        return view('home', [
            'index' => true,
            'sATours' => $sATours,
            'hotTours' => $hotTours,
            'uzTours' => $uzTours,
            'banners' => $banners,
            'setting' => $setting,
        ]);
    }
}
