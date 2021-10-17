<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'admin'], function() {
    
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth'); // ->middleware('auth')は非ログイン時のログイン画面転送用
     // http://XXXXXX.jp/admin/news/create にアクセスが来たら、Controller Admin\NewsController のAction addに渡す という設定
      // mddlewareauthは、ログインしてない人には見せられないようにするためのコード
    Route::get('profile/create', 'Admin\ProfileController@add');
    
    Route::get('profile/index', 'Admin\ProfileController@index');
    
    Route::get('profile/delete', 'Admin\ProfileController@delete');//post?
    
    Route::get('profile/edit', 'Admin\ProfileController@edit');
    
    Route::post('news/create', 'Admin\NewsController@create')->middleware('auth');
    
    Route::post('profile/create', 'Admin\ProfileController@create');
    
    Route::post('profile/edit', 'Admin\ProfileController@update');
    
    Route::get('news', 'Admin\NewsController@index')->middleware('auth');
    // PHP/Laravel16 更新・削除を実装しよう　で追記
    Route::get('news/edit', 'Admin\NewsController@edit')->middleware('auth'); 
    
    Route::post('news/edit', 'Admin\NewsController@update')->middleware('auth');
    // 追記
    Route::get('news/delete', 'Admin\NewsController@delete')->middleware('auth');
});

    // PHP/Laravel 19 フロント で以下を追記 
Route::get('/', 'NewsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');