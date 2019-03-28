<?php

namespace Ulyssetour\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    //
    public function loadImage(Request $request)
    {
        if ($request->has('upload')) {
            $image = $request->file('upload');
            $img = Image::make($image->getRealPath());
            if ($img->width() > 1200)
                $img->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

            $origName = $image->getClientOriginalName();
            $ext = pathinfo($origName, PATHINFO_EXTENSION); // расширение
            $file_name = md5(basename($origName) . time()) . '.' . $ext; // новое имя файла

            $img->save(public_path() . '/images/ckeditor/' . $file_name, 80);
            $imgProfile = '/images/ckeditor/' . $file_name;

            return response()->json(["uploaded" => true, "url" => $imgProfile], 200);
        } else
            return response()->json(["uploaded" => false, "error" => ["message" => "could not upload this image"]], 200);
    }

    //
    public function scheduleApi()
    {
        if (!isset($_POST['link'])) return false;

        $link = $_POST['link'];
        $data = file_get_contents($link);

        echo $data;
    }

    //
    public function bookItSendMailTour(Request $request)
    {
        date_default_timezone_set('Asia/Tashkent');

        $data = $request->all();
        $email = 'info@ulyssetour.com';

        Mail::send('mail/sendCreateTour', $data, function ($m) use ($email) {
            $m->from('webmaster@limitless.uz', 'Уведомление с сайта');

            $m->to($email)->subject('Уведомление с сайта');
        });
    }
}
