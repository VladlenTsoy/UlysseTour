<?php

Route::get('/', 'HomeController@index');
Route::get('/{lang?}', 'HomeController@index')->where('lang', '\w{2}');


Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
