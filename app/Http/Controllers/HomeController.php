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
        if (!$lang) return redirect('/en');
        $language = Language::where('title', $lang)->first();

        $languages = Language::all();
        $guides = Guide::where('lang', $language->title)->latest()->get();
        $news = News::where('lang', $language->title)->latest()->limit(3)->get();
        $sATours = Tour::where(['lang' => $language->title, 'country' => 0, 'hot' => null])->latest()->limit(3)->get();
        $uzTours = Tour::where(['lang' => $language->title, 'country' => 1, 'hot' => null])->latest()->limit(3)->get();
        $hotTours = Tour::where([['lang', '=', $language->title], ['hot', '>', date("Y-m-d")]])->latest()->get();

        $categories = Category::where('lang', $language->title)->get();
        $cities = City::where('lang', $language->title)->get();
        $seasons = Season::where('lang', $language->title)->get();

        $banners = Banner::where('lang', $language->title)->get();

        $setting = [
            'title' => $language->data->title_site,
            'description' => $language->data->description_site,
        ];

        return view('home', [
            'lang' => $language,
            'langs' => $languages,
            'index' => true,
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
