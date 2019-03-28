<?php

namespace Ulyssetour\Http\Controllers;

use Illuminate\Http\Request;
use Ulyssetour\Content\Guide;
use Ulyssetour\Content\News;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\MetaTag;

class NewsController extends Controller
{
    //
    public function all($lang)
    {
        $news = News::where('lang', $lang)->latest()->get();

        $tag = MetaTag::where(['url' => 'news', 'lang' => $lang])->first();
        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();
        $guides = Guide::where('lang', $lang->title)->latest()->get();

        $setting = [
            'title' => $tag && $tag->title ? $tag->title : $lang->data->news,
            'description' => $tag && $tag->description ? $tag->description : $lang->data->description_site,
            'slide_title' => $lang->data->news,
            'slide_desc' => null,
            'slide_img' => '../images/banner/news.png',
        ];

        return view('pages.news.all', [
            'lang' => $lang,
            'langs' => $langs,
            'news' => $news,
            'guides' => $guides,
            'setting' => $setting,
        ]);
    }

    public function getByID($lang, $id)
    {
        $news = News::where(['lang' => $lang, 'id' => $id])->first();
        $new_news = News::where(['lang' => $lang])->whereNotIn('id', ['id' => $news->id])->latest()->get();

        $lang = Language::where('title', $lang)->first();
        $langs = Language::all();
        $guides = Guide::where('lang', $lang->title)->latest()->get();

        $setting = [
            'title' => $news->meta_title,
            'description' => $news->meta_description,
            'slide_title' => $lang->data->news,
            'slide_desc' => '',
            'slide_img' => $news->image,
        ];

        return view('pages.news.select', [
            'lang' => $lang,
            'langs' => $langs,
            'guides' => $guides,
            'news' => $news,
            'new_news' => $new_news,
            'setting' => $setting,
        ]);
    }
}
