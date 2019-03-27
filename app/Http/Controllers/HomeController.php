<?php

namespace Ulyssetour\Http\Controllers;

use Ulyssetour\Content\Banner;
use Ulyssetour\Content\Guide;
use Ulyssetour\Content\News;
use Ulyssetour\Content\Tour;
use Ulyssetour\Setting\Category;
use Ulyssetour\Setting\City;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\Season;

class HomeController extends Controller
{
    public function index($lang = false)
    {
        if (!$lang)
            return redirect('/en');

        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();

        if (!$lang)
            return redirect('/ru');

        $guides = Guide::where('lang', $lang->title)->get();
        $news = News::where('lang', $lang->title)->latest()->limit(3)->get();
        $sATours = Tour::where(['lang' => $lang->title, 'country' => 0, 'hot' => null])->latest()->limit(3)->get();
        $uzTours = Tour::where(['lang' => $lang->title, 'country' => 1, 'hot' => null])->latest()->limit(3)->get();
        $hotTours = Tour::where([['lang', '=', $lang->title], ['hot', '>', date("Y-m-d")]])->latest()->get();

        $categories = Category::where('lang', $lang->title)->get();
        $cities = City::where('lang', $lang->title)->get();
        $seasons = Season::where('lang', $lang->title)->get();

        $banners = Banner::where('lang', $lang->title)
            ->get();

        $setting = [
            'title' => $lang->data->title_site,
            'description' => $lang->data->description_site,
        ];


        return view('home', [
            'lang' => $lang,
            'langs' => $langs,
            'guides' => $guides,
            'news' => $news,
            'sATours' => $sATours,
            'hotTours' => $hotTours,
            'uzTours' => $uzTours,
            'banners' => $banners,
            'categories' => $categories,
            'cities' => $cities,
            'season' => $seasons,
            'setting' => $setting,
        ]);
    }
}
