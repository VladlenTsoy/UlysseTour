<?php

namespace Ulyssetour\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Ulyssetour\Content\Guide;
use Ulyssetour\Content\News;
use Ulyssetour\Service\Accommodation;
use Ulyssetour\Service\Food;
use Ulyssetour\Service\GuideService;
use Ulyssetour\Service\Transport;
use Ulyssetour\Setting\Category;
use Ulyssetour\Setting\City;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\MetaTag;
use Ulyssetour\Setting\Season;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $UrlSite = '';

    public function __construct()
    {
    }

    public function updateLanguage($lang, $tour = false)
    {
        $languages = Language::all();
        $language = Language::where('title', $lang)->first();
        $categories = Category::where('lang', $language->title)->orderBy('title')->get();
        $cities = City::where('lang', $language->title)->orderBy('title')->get();
        $seasons = Season::where('lang', $language->title)->get();

        $news = News::where('lang', $language->title)->latest()->limit(6)->get();
        $guides = Guide::where('lang', $language->title)->latest()->limit(6)->get();

        $tags = [];
        $tags_def = MetaTag::where('lang', 'ru')->get()->groupBy('url');
        $tags_current = MetaTag::where('lang', $language->title)->get()->groupBy('url');

        foreach ($tags_def as $key => $item)
            $tags[$key] = isset($tags_def->{$key}) ? $tags_current->{$key} : $item;

        View::share('_lang', $language);
        View::share('_languages', $languages);
        View::share('_categories', $categories);
        View::share('_cities', $cities);
        View::share('_seasons', $seasons);
        View::share('_news', $news);
        View::share('_guides', $guides);
        View::share('_tags', $tags);

        if ($tour) {
            $accommodations = Accommodation::where('lang', $lang)->get();
            $food = Food::where('lang', $lang)->get();
            $transports = Transport::where('lang', $lang)->get();
            $guideService = GuideService::where('lang', $lang)->get();

            View::share('_accommodations', $accommodations);
            View::share('_food', $food);
            View::share('_transports', $transports);
            View::share('_guideService', $guideService);
        }
    }


    /******* -----------------  Сохранение картинок ------------------  ******/

    /*
     * Обработка картинок
     */
    public function images($images, $quality, $path)
    {
        $imagesObj = Array();

        if (!File::exists(public_path() . $path))
            File::makeDirectory(public_path() . $path);

        if (gettype($images) == "array") {
            foreach ($images['images'] as $file) {

                $imgProfile = $this->saveFiles($file, $quality, $path);
                array_push($imagesObj, $imgProfile);
            }

        } else {

            $imgProfile = $this->saveFiles($images, $quality, $path);
            $imagesObj = $imgProfile;
        }

        return $imagesObj;
    }


    /*
     * Сохранение картинок
     */
    public function saveFiles($images, $quality, $path)
    {
        $img = Image::make($images->getRealPath());
        if ($img->width() > 1200)
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            });

        $origName = $images->getClientOriginalName();
        $ext = pathinfo($origName, PATHINFO_EXTENSION); // расширение
        $file_name = md5(basename($origName) . time()) . '.' . $ext; // новое имя файла

        $img->save(public_path() . $path . $file_name, $quality);
        $imgProfile = $this->UrlSite . $path . $file_name;

        return $imgProfile;
    }


    /*
     * Удаление файлов
     */
    public function deleteFiles($id, $table, $col)
    {
        $tableSelect = DB::table($table)->where('id', $id)
            ->pluck($col)
            ->first();

        if (!$tableSelect) return json_encode(array('status' => 'error', 'message' => ''));

        $images = json_decode($tableSelect);

        if (gettype($images) == "array") {
            foreach ($images as $image) {
                File::delete(public_path() . $image);
            }
        } else {
            if (substr($tableSelect, 24) !== "default.svg")
                if (File::exists(public_path() . $tableSelect))
                    File::delete(public_path() . $tableSelect);
        }

        return json_encode(array('status' => 'success'));
    }

    /******* -----------------  Сохранение картинок ------------------  ******/
}
