<?php

namespace Ulyssetour\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ulyssetour\Content\Charter;
use Ulyssetour\Content\Helicopter;
use Ulyssetour\Content\Tour;
use Ulyssetour\Service\Food;
use Ulyssetour\Service\GuideService;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\MetaTag;

class TourController extends Controller
{
    //
    public function all(Request $request, $lang)
    {
        $this->updateLanguage($lang, true);
        $language = Language::where('title', $lang)->first();
        $search = ['lang' => $language->title, 'hot' => null, 'country' => 0, 'helicopter' => 0];

        // Получения атр
        $search['country'] = $request->has('country') ? $request->get('country') : 0;

        // Вывод тегов
        $tag = MetaTag::where(['url' => "tours-" . $search['country'], 'lang' => $language->title])->first();

        if(!$tag)
            $tag = MetaTag::where(['url' => "tours-" . $search['country'], 'lang' => 'ru'])->first();

        $setting = [
            'title' => $tag->title,
            'description' => $tag->description,
            'request_tour' => $request->has('country'),
            'slide_img' => $search['country'] == 0 ? '/files/tour.png' : '/files/c-asia.png',
            'slide_title' => $language->data->country[$search['country']],
            'slide_desc' => $language->data->tours
        ];


        if ($request->has('category') && $request->get('category') != 0)
            $search['category'] = $request->get('category');

        if ($request->has('season') && $request->get('season') != 0)
            $search['season'] = $request->get('season');

        if ($request->has('join_the_group') && $request->get('join_the_group') != 0)
            if ($request->get('join_the_group') != 0)
                if ($request->get('join_the_group') == 1)
                    $search['join_group'] = 1;
                elseif ($request->get('join_the_group') == 2) {
                    $search['join_group'] = null;
                    $nullJoin = true;
                }

        $tours = Tour::where($search)->latest()->get();

        if (isset($nullJoin))
            if ($search['join_group'] === null)
                $search['join_group'] = 2;

        $toursFilter = [];

        foreach ($tours as $tour) {
            $city = $request->get('city');
            $_city = false;

            if ($city != 0) {
                if ($tour->city != null)
                    if (array_search($city, $tour->city) !== false) $_city = true;
                    else $_city = false;
            } else
                $_city = true;


            $_count_people = true;

            if ($_city && $_count_people)
                array_push($toursFilter, $tour);
        }

        if ($request->has('city') && $request->get('city') != 0)
            $search['city'] = $request->get('city');

        if ($request->has('count_people') && $request->get('count_people') != 0)
            $search['count_people'] = $request->get('count_people');


        return view('pages.tours.all', [
            'country' => $search['country'],
            'tours' => $toursFilter,
            'search' => $search,
            'setting' => $setting,
        ]);
    }

    //
    public function getByID($lang, $id)
    {
        $this->updateLanguage($lang);
        $tour = Tour::where(['lang' => $lang, 'id' => $id])->first();
        $lang = Language::where('title', $lang)->first();

        $ids_transport = $tour->include_transport ?? [];
        if ($ids_transport)
            $transports = DB::table('transports')->where('lang', $lang->title)
                ->whereIn('id', $ids_transport)
                ->orderByRaw(DB::raw("FIELD(id, " . implode(',', $ids_transport) . ")"))
                ->get();
        else
            $transports = [];

        $ids_accommodations = $tour->include_accommodations ?? [];
        $accommodations = DB::table('accommodations')->whereIn('id', $ids_accommodations)->get();

        $ids_food = $tour->include_food ?? [];
        $food = Food::whereIn('id', $ids_food)->get();
        $food_sub = Food::where('lang', $lang->title)->get();

        $ids_guide_service = $tour->include_guide ?? [];
        $guideService = GuideService::whereIn('id', $ids_guide_service)->get();

        $setting = [
            'title' => $tour->meta_title,
            'description' => $tour->meta_description,
            'slide_title' => $tour->title,
            'slide_desc' => '',
            'slide_img' => $tour->image,
        ];

        return view('pages.tours.select', [
            'lang' => $lang,
            'tour' => $tour,
            'transports' => $transports,
            'accommodations' => $accommodations,
            'food' => $food,
            'food_sub' => $food_sub,
            'guideService' => $guideService,
            'setting' => $setting,
        ]);
    }

    //
    public function hotTours(Request $request, $lang)
    {
        $this->updateLanguage($lang);
        $lang = Language::where('title', $lang)->first();
        $tag = MetaTag::where(['url' => 'hot-tours', 'lang' => $lang->title])->first();

        $setting = [
            'link' => 'hot-tour',
            'title' => $tag && $tag->title ? $tag->title : $lang->data->hot_tours,
            'description' => $tag && $tag->description ? $tag->description : $lang->data->description_site,
            'slide_title' => $lang->data->hot_tours,
            'slide_desc' => '',
            'slide_img' => '../images/banner/hot-tour.png',
        ];

        $search = ['lang' => $lang->title];

        if ($request->has('category') && $request->get('category') != 0)
            $search['category'] = $request->get('category');

        if ($request->has('season') && $request->get('season') != 0)
            $search['season'] = $request->get('season');

        if ($request->has('join_the_group') && $request->get('join_the_group') != 0)
            if ($request->get('join_the_group') != 0)
                if ($request->get('join_the_group') == 1)
                    $search['join_group'] = 1;
                elseif ($request->get('join_the_group') == 2) {
                    $search['join_group'] = null;
                    $nullJoin = true;
                }

        $tours = Tour::where($search)->where([['hot', '>', date('Y-m-d')]])->latest()->get();
        $toursFilter = [];

        if (isset($nullJoin))
            if ($search['join_group'] === null)
                $search['join_group'] = 2;

        foreach ($tours as $tour) {
            $city = $request->get('city');
            $_city = false;

            if ($city != 0) {
                if ($tour->city != null)
                    if (array_search($city, $tour->city) !== false) $_city = true;
                    else $_city = false;
            } else
                $_city = true;

            $_count_people = true;

            if ($_city && $_count_people)
                array_push($toursFilter, $tour);
        }

        if ($request->has('city') && $request->get('city') != 0)
            $search['city'] = $request->get('city');

        if ($request->has('count_people') && $request->get('count_people') != 0)
            $search['count_people'] = $request->get('count_people');

        return view('pages.tours.all', [
            'hot' => true,
            'tours' => $toursFilter,
            'search' => $search,
            'setting' => $setting,
        ]);
    }

    //
    public function hotTourGetByID($lang, $id)
    {
        $this->updateLanguage($lang);
        $tour = Tour::where(['lang' => $lang, 'id' => $id])->first();
        $lang = Language::where('title', $lang)->first();

        $ids_transport = $tour->include_transport ?? [];
        $transports = DB::table('transports')->whereIn('id', $ids_transport)->get();


        $ids_accommodations = $tour->include_accommodations ?? [];
        $accommodations = DB::table('accommodations')->whereIn('id', $ids_accommodations)->get();

        $ids_food = $tour->include_food ?? [];
        $food = Food::whereIn('id', $ids_food)->get();
        $food_sub = Food::where('lang', $lang->title)->get();

        $ids_guide_service = $tour->include_guide ?? [];
        $guideService = GuideService::whereIn('id', $ids_guide_service)->get();

        $setting = [
            'title' => $tour->meat_title,
            'description' => $tour->meta_description,
            'slide_title' => $tour->title,
            'slide_desc' => '',
            'slide_img' => $tour->image,
        ];

        return view('pages.tours.select', [
            'tour' => $tour,
            'hot' => true,
            'transports' => $transports,
            'accommodations' => $accommodations,
            'food' => $food,
            'food_sub' => $food_sub,
            'guideService' => $guideService,
            'setting' => $setting,
        ]);
    }

    //
    public function helinatureTours(Request $request, $lang)
    {
        $this->updateLanguage($lang, true);
        $language = Language::where('title', $lang)->first();
        $search = ['lang' => $language->title, 'hot' => null, 'helicopter' => 1];
        $helicopters = Helicopter::where('lang', $language->title)->get();

        // Вывод тегов
        $tag = MetaTag::where(['url' => "helinature", 'lang' => $language->title])->first();
        if(!$tag)
            $tag = MetaTag::where(['url' => "helinature", 'lang' => 'ru'])->first();

        $setting = [
            'title' => $tag->title,
            'description' => $tag->description,
            'request_tour' => $request->has('country'),
            'slide_img' => '/images/banner/hot-tour.png',
            'slide_title' => $language->data->helinature,
            'slide_desc' => $language->data->tours
        ];

        $tours = Tour::where($search)->latest()->get();

        return view('pages.tours.all', [
            'tours' => $tours,
            'helinature' => true,
            'helicopters' => $helicopters,
            'setting' => $setting,
        ]);
    }

    //
    public function heliskiTours($lang)
    {
        $this->updateLanguage($lang);
        $language = Language::where('title', $lang)->first();

        // Вывод тегов
        $tag = MetaTag::where(['url' => "heliski", 'lang' => $language->title])->first();
        if(!$tag)
            $tag = MetaTag::where(['url' => "heliski", 'lang' => 'ru'])->first();

        $setting = [
            'title' => $tag->title,
            'description' => $tag->description,
            'text' => $language->data->heliski_text,
            'slide_img' => '/files/c-asia.png',
            'slide_title' => $language->data->heliski,
            'slide_desc' => $language->data->tours
        ];

        return view('pages.tours.heliski', [
            'lang' => $lang,
            'setting' => $setting,
        ]);
    }

    //
    public function businessFlyTours($lang)
    {
        $this->updateLanguage($lang);
        $language = Language::where('title', $lang)->first();
        $charters = Charter::where('lang', $language->title)->get();

        // Вывод тегов
        $tag = MetaTag::where(['url' => "business_fly", 'lang' => $language->title])->first();
        if(!$tag)
            $tag = MetaTag::where(['url' => "business_fly", 'lang' => 'ru'])->first();

        $setting = [
            'title' => $tag->title,
            'description' => $tag->description,
            'slide_img' => '/files/c-asia.png',
            'slide_title' => $language->data->business_fly,
            'slide_desc' => $language->data->tours
        ];

        return view('pages.tours.business_fly', [
            'lang' => $lang,
            'charters' => $charters,
            'setting' => $setting,
        ]);
    }
}
