<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ulyssetour\Content\News;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;

class NewsController extends Controller
{
    //
    /**
     */
    public function news()
    {
        $news = News::all();
        return view('admin.news.news', ['news' => $news]);
    }

    /**
     */
    public function newsCreate()
    {
        $lang = Language::all();
        return view('admin.news.create', ['lang' => $lang]);
    }

    /**
     */
    public function newsCreating(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $lang = $request->get('lang');

        $newsId = News::create([
            'title' => $title,
            'meta_title' => $request->get('meta_title'),
            'meta_description' => $request->get('meta_description'),
            'url' => $request->get('url'),
            'description' => $description,
            'lang' => $lang,
        ])->id;

        if ($request->has('image')) {
            $image = $request->file('image');
            $image = $this->images($image, 60, '/images/news/' . $newsId . '/');

            News::find($newsId)->update(['image' => $image]);
        }

        return redirect()->intended('/admin/news');
    }

    /**
     */
    public function newsGetById($id)
    {
        $lang = Language::all();
        $news = News::find($id);
        return view('admin.news.edit', ['news' => $news, 'lang' => $lang]);
    }

    /**
     */
    public function newsEditById(Request $request, $id)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $lang = $request->get('lang');

        News::find($id)->update([
            'title' => $title,
            'description' => $description,
            'meta_title' => $request->get('meta_title'),
            'meta_description' => $request->get('meta_description'),
            'url' => $request->get('url'),
            'lang' => $lang,
        ]);

        if ($request->has('image')) {
            $this->deleteFiles($id, 'news', 'image');

            $image = $request->file('image');
            $image = $this->images($image, 60, '/images/news/' . $id . '/');

            News::find($id)->update(['image' => $image]);
        }

        return redirect()->intended('/admin/news');
    }

    /**
     */
    public function newsDeleteById($id)
    {
        News::find($id)->delete();
        return redirect()->intended('/admin/news');
    }
}
