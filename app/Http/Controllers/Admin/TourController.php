<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ulyssetour\Content\Tour;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Service\Accommodation;
use Ulyssetour\Service\Food;
use Ulyssetour\Service\GuideService;
use Ulyssetour\Service\Service;
use Ulyssetour\Service\Transport;
use Ulyssetour\Setting\Category;
use Ulyssetour\Setting\City;
use Ulyssetour\Setting\Duration;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\Season;

class TourController extends Controller
{
    //
    public function all()
    {
        $tours = Tour::all();
        $langs = Language::all();
        $lang = Language::where('title', 'ru')->first();
        return view('admin.tours.tours', ['tours' => $tours, 'langs' => $langs, 'lang' => $lang->data]);
    }

    //
    public function tourCreate($lang)
    {
        $categories = Category::where('lang', $lang)->get();
        $cities = City::where('lang', $lang)->get();
        $durations = Duration::where('lang', $lang)->get();
        $seasons = Season::where('lang', $lang)->get();

        $transports = Transport::where('lang', $lang)->get();
        $guideServices = GuideService::where('lang', $lang)->get();
        $food = Food::where('lang', $lang)->get();
        $services = Service::where('lang', $lang)->get();
        $accommodations = Accommodation::where('lang', $lang)->get();

        return view('admin.tours.create', [
            'categories' => $categories,
            'cities' => $cities,
            'durations' => $durations,
            'seasons' => $seasons,
            'transports' => $transports,
            'guideSevices' => $guideServices,
            'food' => $food,
            'services' => $services,
            'accommodations' => $accommodations,
            'lang' => $lang,
        ]);
    }

    /** **/
    public function tourCreating(Request $request, $lang)
    {
        $saveObj = [];
        $saveObj['meta_title'] = $request->get('meta_title');
        $saveObj['meta_description'] = $request->get('meta_description');
        $saveObj['url'] = $request->get('url');
        $saveObj['title'] = $request->get('title');
        $saveObj['category'] = $request->get('category');
        $saveObj['duration'] = $request->get('duration');
        $saveObj['cost'] = $request->get('cost');
        $saveObj['city'] = json_encode($request->get('city'));
        $saveObj['max_qty_tourists'] = $request->get('max_qty_tourists');
        $saveObj['season'] = $request->get('season');
        $saveObj['schedule'] = $request->get('schedule');
        $saveObj['description'] = $request->get('description');
        $saveObj['hot'] = $request->get('hot');

        if ($request->has('program_title')) {
            $saveObj['program'] = [];
            foreach ($request->get('program_title') as $key => $title) {
                array_push($saveObj['program'], [
                    'title' => $title,
                    'description' => $request->get('program_desc')[$key] ?? null,
                ]);
            }
            $saveObj['program'] = json_encode($saveObj['program']);
        }

        if ($request->has('lat')) {
            $saveObj['route'] = [];
            foreach ($request->get('lat') as $key => $title) {
                array_push($saveObj['route'], [
                    'lat' => $request->get('lat')[$key],
                    'lng' => $request->get('lng')[$key],
                ]);
            }
            $saveObj['route'] = json_encode($saveObj['route']);
        }

        $saveObj['include_transport'] = json_encode($request->get('include_transports'));
        $saveObj['include_guide'] = json_encode($request->get('include_guide'));
        $saveObj['include_food'] = json_encode($request->get('include_food'));
        $saveObj['include_service'] = json_encode($request->get('include_services'));
        $saveObj['include_accommodations'] = json_encode($request->get('include_accommodations'));

        $saveObj['ad_service'] = json_encode($request->get('ad_services'));
//        $saveObj['ad_guide'] = json_encode($request->get('ad_guide'));
//        $saveObj['ad_transport'] = json_encode($request->get('ad_transport'));
//        $saveObj['ad_food'] = json_encode($request->get('ad_food'));
//        $saveObj['ad_accommodations'] = json_encode($request->get('ad_accommodations'));

        $saveObj['conditions'] = ($request->get('conditions'));
        $saveObj['country'] = ((int)$request->get('country'));
        $saveObj['lang'] = $lang;
        $saveObj['join_group'] = $request->has('join_group') ? $request->get('join_group') : null;

        $tourId = Tour::create($saveObj)->id;

        if ($request->has('image')) {
            $image = $request->file('image');
            $image = $this->images($image, 60, '/images/tours/' . $tourId . '/');

            Tour::find($tourId)->update(['image' => $image]);
        }

        return redirect()->intended('/admin/tours');
    }

    /** **/
    public function tourGetById($id, $lang)
    {
        $tour = Tour::find($id);
        if (!$tour)
            return view('admin.tours.notFound');

        $ids_transport = $tour->include_transport ?? [];
        $ids_city = $tour->city ?? [];

        $categories = Category::where('lang', $lang)->get();

        if ($ids_city)
            $cities = City::where('lang', $lang)
                ->orderByRaw(DB::raw("FIELD(id, " . implode(',', $ids_city) . ")"))
                ->get();
        else
            $cities = City::where('lang', $lang)
                ->get();

        $durations = Duration::where('lang', $lang)->get();
        $seasons = Season::where('lang', $lang)->get();

        if ($ids_transport)
            $transports = Transport::where('lang', $lang)
                ->orderByRaw(DB::raw("FIELD(id, " . implode(',', $ids_transport) . ")"))
                ->get();
        else
            $transports = Transport::where('lang', $lang)
                ->get();

        $guideServices = GuideService::where('lang', $lang)->get();
        $food = Food::where('lang', $lang)->get();
        $services = Service::where('lang', $lang)->get();
        $accommodations = Accommodation::where('lang', $lang)->get();

        return view('admin.tours.edit', [
            'categories' => $categories,
            'cities' => $cities,
            'durations' => $durations,
            'seasons' => $seasons,
            'transports' => $transports,
            'guideSevices' => $guideServices,
            'food' => $food,
            'services' => $services,
            'accommodations' => $accommodations,
            'lang' => $lang,
            'tour' => $tour,
            'id' => $id,
        ]);
    }

    public function tourEditById(Request $request, $id, $lang)
    {
        $saveObj = [];
        $saveObj['meta_title'] = $request->get('meta_title');
        $saveObj['meta_description'] = $request->get('meta_description');
        $saveObj['url'] = $request->get('url');
        $saveObj['title'] = $request->get('title');
        $saveObj['category'] = $request->get('category');
        $saveObj['duration'] = $request->get('duration');
        $saveObj['cost'] = $request->get('cost');
        $saveObj['city'] = json_encode($request->get('city'));
        $saveObj['max_qty_tourists'] = $request->get('max_qty_tourists');
        $saveObj['season'] = $request->get('season');
        $saveObj['schedule'] = $request->get('schedule');
        $saveObj['description'] = $request->get('description');
        $saveObj['hot'] = $request->get('hot');

        if ($request->has('program_title')) {
            $saveObj['program'] = [];
            foreach ($request->get('program_title') as $key => $title) {
                array_push($saveObj['program'], [
                    'title' => $title,
                    'description' => $request->get('program_desc')[$key] ?? null,
                ]);
            }
            $saveObj['program'] = json_encode($saveObj['program']);
        }

        $saveObj['include_transport'] = $request->get('include_transports') ? json_encode($request->get('include_transports')) : null;
        $saveObj['include_guide'] = $request->get('include_guide') ? json_encode($request->get('include_guide')) : null;
        $saveObj['include_food'] = $request->get('include_food') ? json_encode($request->get('include_food')) : null;
        $saveObj['include_service'] = $request->get('include_services') ? json_encode($request->get('include_services')) : null;
        $saveObj['include_accommodations'] = $request->get('include_accommodations') ? json_encode($request->get('include_accommodations')) : null;

        $saveObj['ad_service'] = $request->get('ad_services') ? json_encode($request->get('ad_services')) : null;
//        $saveObj['ad_guide'] = json_encode($request->get('ad_guide'));
//        $saveObj['ad_transport'] = json_encode($request->get('ad_transport'));
//        $saveObj['ad_food'] = json_encode($request->get('ad_food'));
//        $saveObj['ad_accommodations'] = json_encode($request->get('ad_accommodations'));

        if ($request->has('lat')) {
            $saveObj['route'] = [];
            foreach ($request->get('lat') as $key => $title) {
                array_push($saveObj['route'], [
                    'lat' => $request->get('lat')[$key],
                    'lng' => $request->get('lng')[$key],
                ]);
            }
            $saveObj['route'] = json_encode($saveObj['route']);
        }

        $saveObj['conditions'] = $request->get('conditions');
        $saveObj['country'] = (int)$request->get('country');
        $saveObj['lang'] = $lang;
        $saveObj['join_group'] = $request->has('join_group') ? $request->get('join_group') : null;

        if ($request->has('image')) {
            $this->deleteFiles($id, 'tours', 'image');

            $image = $request->file('image');
            $image = $this->images($image, 60, '/images/tours/' . $id . '/');

            $saveObj['image'] = $image;
        }

        Tour::find($id)->update($saveObj);
        return redirect()->intended('/admin/tours');
    }

    /**  **/
    public function tourDeleteById($id)
    {
        Tour::find($id)->delete();
        return redirect()->intended('/admin/tours');
    }
}
