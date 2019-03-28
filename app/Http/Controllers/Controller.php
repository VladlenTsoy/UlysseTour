<?php

namespace Ulyssetour\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


//    public $UrlSite = 'https://api.eon.uz';
    public $UrlSite = '';

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
