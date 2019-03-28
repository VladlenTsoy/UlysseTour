<?php

namespace Ulyssetour\Http\Controllers;

use Ulyssetour\Content\Guide;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\MetaTag;

class GuideController extends Controller
{
    //
    public function all($lang)
    {
        $guide = Guide::where(['lang' => $lang])->latest()->get();

        $tag = MetaTag::where(['url' => 'guides', 'lang' => $lang])->first();
        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();
        $guides = Guide::where('lang', $lang->title)->get();

        $setting = [
            'title' => $tag && $tag->title ? $tag->title : $lang->data->guide,
            'description' => $tag && $tag->description ? $tag->description : $lang->data->description_site,
            'slide_title' => $lang->data->guide,
            'slide_desc' => '',
            'slide_img' => '../images/banner/guide.png',
            'guide_off' => true,
        ];

        return view('pages.guides.all', [
            'lang' => $lang,
            'langs' => $langs,
            'guides' => $guides,
            'guide' => $guide,
            'setting' => $setting,
        ]);
    }

    //
    public function getByID($lang, $id)
    {
        $guide = Guide::where(['lang' => $lang, 'id' => $id])->first();

        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();
        $guides = Guide::where('lang', $lang->title)->get();

        $setting = [
            'title' => $guide->meta_title,
            'description' => $guide->meta_description,
            'slide_title' => $lang->data->guide,
            'slide_desc' => '',
            'slide_img' => '../../images/banner/guide.png',
        ];

        return view('pages.guides.select', [
            'lang' => $lang,
            'langs' => $langs,
            'guides' => $guides,
            'guide' => $guide,
            'setting' => $setting,
        ]);
    }
}
