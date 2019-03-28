<?php

namespace Ulyssetour\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ulyssetour\Content\Banner;
use Ulyssetour\Http\Controllers\Controller;
use Ulyssetour\Setting\Language;

class BannerController extends Controller
{
    //
    /**
     */
    public function banners()
    {
        $banners = Banner::get();
        return view('admin.banner.banners', ['banners' => $banners]);
    }

    /**
     */
    public function bannerCreate()
    {
        $lang = Language::all();
        return view('admin.banner.create', ['lang' => $lang]);
    }

    /**
     */
    public function bannerCreating(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('sub_title');
        $link = $request->get('link');
        $name_link = $request->get('name_link');
        $lang = $request->get('lang');

        $bannerId = Banner::insertGetId([
            'title' => $title,
            'sub_title' => $description,
            'link' => $link,
            'name_link' => $name_link,
            'lang' => $lang,
        ]);

        if ($request->has('image')) {
            $image = $request->file('image');
            $image = $this->images($image, 60, '/images/banner/' . $bannerId . '/');

            Banner::where('id', $bannerId)->update(['image' => $image]);
        }

        return redirect()->intended('/admin/banners');
    }

    /**
     */
    public function bannerGetById($id)
    {
        $lang = Language::all();
        $banner = Banner::where('id', $id)->first();
        return view('admin.banner.edit', ['banner' => $banner, 'lang' => $lang]);
    }

    /**
     */
    public function bannerEditById(Request $request, $id)
    {
        $title = $request->get('title');
        $description = $request->get('sub_title');
        $link = $request->get('link');
        $name_link = $request->get('name_link');
        $lang = $request->get('lang');

        Banner::where('id', $id)
            ->update([
                'title' => $title,
                'sub_title' => $description,
                'link' => $link,
                'name_link' => $name_link,
                'lang' => $lang,
            ]);

        if ($request->has('image')) {
            $this->deleteFiles($id, 'news', 'image');

            $image = $request->file('image');
            $image = $this->images($image, 60, '/images/banner/' . $id . '/');

            Banner::where('id', $id)->update(['image' => $image]);
        }

        return redirect()->intended('/admin/banners');
    }

    /**
     */
    public function bannerDeleteById($id)
    {
        Banner::where('id', $id)->delete();
        return redirect()->intended('/admin/banners');
    }
}
