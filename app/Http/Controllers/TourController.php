<?php

namespace Ulyssetour\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ulyssetour\Content\Guide;
use Ulyssetour\Content\Tour;
use Ulyssetour\Service\Food;
use Ulyssetour\Service\GuideService;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\MetaTag;
use Ulyssetour\Setting\Season;

class TourController extends Controller
{
    //
    public function all(Request $request, $lang)
    {
        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();

        $categories = DB::table('categories')->where('lang', $lang->title)->get();
        $cities = DB::table('cities')->where('lang', $lang->title)->get();
        $seasons = Season::where('lang', $lang->title)->get();
        $accommodations = DB::table('accommodations')->where('lang', $lang->title)->get();
        $food = Food::where('lang', $lang->title)->get();
        $transports = DB::table('transports')->where('lang', $lang->title)->get();
        $guideService = GuideService::where('lang', $lang->title)->get();

        $guides = Guide::where('lang', $lang->title)->get();

        $setting = [
            'title' => $lang->data->tours,
            'description' => $lang->data->description_site,
            'request_tour' => $request->has('country'),
            'slide_img' => '../images/banner/tour.png',
        ];

        $search = ['lang' => $lang->title, 'hot' => null];

        if ($request->has('country')) {
            $search['country'] = $request->get('country');
            $tag = MetaTag::where(['url' => "tours-".$search['country'], 'lang' => $lang->title])->first();
            $setting['title'] = $tag->title;
            $setting['description'] = $tag->description;
            $setting['slide_title'] = $lang->data->country[$search['country']];
            $setting['slide_desc'] = $lang->data->tours;
            $setting['slide_img'] = $request->get('country') == 0 ? '../files/tour.png' : '../files/c-asia.png';
        } else {
            $setting['slide_title'] = $lang->data->tours;
            $setting['slide_desc'] = '';
        }

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

        $tours = Tour::where($search)->get();

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
            'lang' => $lang,
            'langs' => $langs,
            'country' => $search['country'] ?? null,
            'guides' => $guides,
            'categories' => $categories,
            'accommodations' => $accommodations,
            'cities' => $cities,
            'seasons' => $seasons,
            'transports' => $transports,
            'guideService' => $guideService,
            'tours' => $toursFilter,
            'food' => $food,
            'search' => $search,
            'setting' => $setting,
        ]);
    }

    //
    public function getByID($lang, $id)
    {
        $tour = Tour::where(['lang' => $lang, 'id' => $id])->first();

        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();
        $guides = Guide::where('lang', $lang->title)->get();

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
            'description' => $tour->meta_discription,
            'slide_title' => $tour->title,
            'slide_desc' => '',
            'slide_img' => $tour->image,
        ];

        return view('pages.tours.select', [
            'lang' => $lang,
            'langs' => $langs,
            'guides' => $guides,
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
        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();
        $tag = MetaTag::where(['url' => 'hot-tours', 'lang' => $lang->title])->first();

        $categories = DB::table('categories')->where('lang', $lang->title)->get();
        $cities = DB::table('cities')->where('lang', $lang->title)->get();
        $seasons = Season::where('lang', $lang->title)->get();

        $guides = Guide::where('lang', $lang->title)->get();

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

        $tours = Tour::where($search)->where([['hot', '>', date('Y-m-d')]])->get();
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
            'lang' => $lang,
            'langs' => $langs,
            'guides' => $guides,
            'categories' => $categories,
            'cities' => $cities,
            'hot' => true,
            'seasons' => $seasons,
            'tours' => $toursFilter,
            'search' => $search,
            'setting' => $setting,
        ]);
    }

    //
    public function hotTourGetByID($lang, $id)
    {
        $tour = Tour::where(['lang' => $lang, 'id' => $id])->first();

        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();
        $guides = Guide::where('lang', $lang->title)->get();

        $ids_transport = $tour->include_transport ?? [];
        $transports = DB::table('transports')->whereIn('id', $ids_transport)->get();


        $ids_accommodations = $tour->include_accommodations ?? [];
        $accommodations = DB::table('accommodations')->whereIn('id', $ids_accommodations)->get();

        $ids_food = $tour->include_food ?? [];
        $food = DB::table('food')->whereIn('id', $ids_food)->get();
        $food_sub = DB::table('food')->where('lang', $lang->title)->get();

        $ids_guide_service = $tour->include_guide ?? [];
        $guideService = DB::table('guide-sevice')->whereIn('id', $ids_guide_service)->get();

        $setting = [
            'title' => $tour->meat_title,
            'description' => $tour->meat_description,
//            'description' => $lang->data->description,
            'slide_title' => $tour->title,
            'slide_desc' => '',
            'slide_img' => $tour->image,
        ];

        return view('pages.tours.select', [
            'lang' => $lang,
            'langs' => $langs,
            'guides' => $guides,
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
}
