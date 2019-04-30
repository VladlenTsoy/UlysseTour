<?php

namespace Ulyssetour\Http\Controllers;

use Ulyssetour\Content\News;
use Ulyssetour\Setting\Language;
use Ulyssetour\Setting\MetaTag;

class NewsController extends Controller
{
    // Вывод всех новостей
    public function all($lang)
    {
        $this->updateLanguage($lang);
        $news = News::where('lang', $lang)->latest()->get();
        $tag = MetaTag::where(['url' => 'news', 'lang' => $lang])->first();
        $language = Language::where('title', $lang)->first();

        $setting = [
            'title' => $tag->title,
            'description' => $tag->description,
            'slide_title' => $language->data->news,
            'slide_desc' => null,
            'slide_img' => '/files/news.png',
        ];

        return view('pages.news.all', ['news' => $news, 'setting' => $setting]);
    }

    // Вывод ноаости по id
    public function getByID($lang, $id)
    {
        $this->updateLanguage($lang);
        $news = News::where(['lang' => $lang, 'id' => $id])->first();
        $new_news = News::where(['lang' => $lang])->whereNotIn('id', ['id' => $news->id])->latest()->get();
        $language = Language::where('title', $lang)->first();

        $setting = [
            'title' => $news->meta_title,
            'description' => $news->meta_description,
            'slide_title' => $language->data->news,
            'slide_desc' => '',
            'slide_img' => $news->image,
        ];

        return view('pages.news.select', ['news' => $news, 'new_news' => $new_news, 'setting' => $setting]);
    }
}
