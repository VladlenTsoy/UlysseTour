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
        $this->updateLanguage($lang);
        $tag = MetaTag::where(['url' => 'guides', 'lang' => $lang])->first();
        $guide = Guide::where(['lang' => $lang])->latest()->get();
        $language = Language::where('title', $lang)->first();

        $setting = [
            'title' => $tag->title,
            'description' => $tag->description,
            'slide_title' => $language->data->guide,
            'slide_desc' => '',
            'slide_img' => '/files/guide.png',
            'guide_off' => true,
        ];

        return view('pages.guides.all', ['guide' => $guide, 'setting' => $setting]);
    }

    //
    public function getByID($lang, $id)
    {
        $this->updateLanguage($lang);
        $guide = Guide::where(['lang' => $lang, 'id' => $id])->first();
        $language = Language::where('title', $lang)->first();

        $setting = [
            'title' => $guide->meta_title,
            'description' => $guide->meta_description,
            'slide_title' => $language->data->guide,
            'slide_desc' => '',
            'slide_img' => '/images/banner/guide.png',
        ];

        return view('pages.guides.select', ['guide' => $guide, 'setting' => $setting]);
    }
}
