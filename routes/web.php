<?php

Route::get('/', 'HomeController@index');
Route::get('/{lang?}', 'HomeController@index')->where('lang', '\w{2}');


Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login')->name('register');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

Route::post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset');


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'Admin\HomeController@index')->name('home');
    Route::get('/home', 'Admin\HomeController@index')->name('home');

    Route::post('/load/image', 'SettingController@loadImage');


    Route::get('/tours', 'Admin\TourController@all');

    Route::get('/tour/create/{lang}', 'Admin\TourController@tourCreate');
    Route::post('/tour/create/{lang}', 'Admin\TourController@tourCreating');
    Route::get('/tour/{id}/{lang}', 'Admin\TourController@tourGetById')->where('id', '[0-9]+');
    Route::post('/tour/{id}/edit/{lang}', 'Admin\TourController@tourEditById')->where('id', '[0-9]+');
    Route::get('/tour/{id}/delete/{lang}', 'Admin\TourController@tourDeleteById')->where('id', '[0-9]+');


    Route::get('/news', 'Admin\NewsController@news');

    Route::get('/news/create', 'Admin\NewsController@newsCreate');
    Route::post('/news', 'Admin\NewsController@newsCreating');
    Route::get('/news/{id}', 'Admin\NewsController@newsGetById')->where('id', '[0-9]+');
    Route::post('/news/{id}', 'Admin\NewsController@newsEditById')->where('id', '[0-9]+');
    Route::get('/news/{id}/delete', 'Admin\NewsController@newsDeleteById')->where('id', '[0-9]+');

    Route::get('/guides', 'Admin\GuideController@guides');

    Route::get('/guide/create', 'Admin\GuideController@guideCreate');
    Route::post('/guide', 'Admin\GuideController@guideCreating');
    Route::get('/guide/{id}', 'Admin\GuideController@guideGetById')->where('id', '[0-9]+');
    Route::post('/guide/{id}', 'Admin\GuideController@guideEditById')->where('id', '[0-9]+');
    Route::get('/guide/{id}/delete', 'Admin\GuideController@guideDeleteById')->where('id', '[0-9]+');


    Route::get('/languages', 'Admin\LanguageController@languages');

    Route::get('/language/create', 'Admin\LanguageController@languageCreate');
    Route::post('/language', 'Admin\LanguageController@languageCreating');
    Route::get('/language/{id}', 'Admin\LanguageController@languageGetById')->where('id', '[0-9]+');
    Route::post('/language/{id}', 'Admin\LanguageController@languageEditById')->where('id', '[0-9]+');
    Route::get('/language/{id}/delete', 'Admin\LanguageController@languageDeleteById')->where('id', '[0-9]+');

    Route::get('/banners', 'Admin\BannerController@banners');

    Route::get('/banner/create', 'Admin\BannerController@bannerCreate');
    Route::post('/banner', 'Admin\BannerController@bannerCreating');
    Route::get('/banner/{id}', 'Admin\BannerController@bannerGetById')->where('id', '[0-9]+');
    Route::post('/banner/{id}', 'Admin\BannerController@bannerEditById')->where('id', '[0-9]+');
    Route::get('/banner/{id}/delete', 'Admin\BannerController@bannerDeleteById')->where('id', '[0-9]+');

    Route::get('/include/{table}', 'Admin\ServiceController@services');

    Route::get('/include/{table}/create', 'Admin\ServiceController@serviceCreate');
    Route::post('/include/{table}', 'Admin\ServiceController@serviceCreating');
    Route::get('/include/{table}/{id}', 'Admin\ServiceController@serviceGetById')->where('id', '[0-9]+');
    Route::post('/include/{table}/{id}', 'Admin\ServiceController@serviceEditById')->where('id', '[0-9]+');
    Route::get('/include/{table}/{id}/delete', 'Admin\ServiceController@serviceDeleteById')->where('id', '[0-9]+');

    Route::get('/tags', 'Admin\MetatagController@all');
    Route::get('/tag/create/{lang}', 'Admin\MetatagController@сreate');
    Route::get('/tag/{id}', 'Admin\MetatagController@getById');
    Route::post('/tag/{id}', 'Admin\MetatagController@editById');


    Route::get('/{table}', 'Admin\SubController@selectAllTable');

    Route::get('/{table}/create', 'Admin\SubController@tableCreate');
    Route::post('/{table}', 'Admin\SubController@tableCreating');
    Route::get('/{table}/{id}', 'Admin\SubController@tableGetById')->where('id', '[0-9]+');
    Route::post('/{table}/{id}', 'Admin\SubController@tableEditById')->where('id', '[0-9]+');
    Route::get('/{table}/{id}/delete', 'Admin\SubController@tableDeleteById')->where('id', '[0-9]+');
});


Route::post('/book_it/send_mail_message/tour', 'SettingController@bookItSendMailTour');
Route::post('/book_it/send_mail_message/create_tour', 'SettingController@bookItSendMailTour');
Route::post('/schedule', ['as' => 'id', 'uses' => 'SettingController@scheduleApi']);


Route::get('/{lang}/tour/{id}/{title?}', 'TourController@getByID')->where('id', '[0-9]+');
Route::get('/{lang}/tours/{title?}', 'TourController@all');

//
Route::get('/{lang}/hot-tour/{id}/{title?}', 'TourController@hotTourGetByID')->where('id', '[0-9]+');
Route::get('/{lang}/hot-tours/{title?}', 'TourController@hotTours');

//
Route::get('/{lang}/news/{id}/{title?}', 'NewsController@getByID')->where('id', '[0-9]+');
Route::get('/{lang}/news/{title?}', 'NewsController@all');

//
Route::get('/{lang}/guide/{id}/{title?}', 'GuideController@getByID')->where('id', '[0-9]+');
Route::get('/{lang}/guide/{title?}', 'GuideController@all');
