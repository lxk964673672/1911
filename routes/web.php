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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user/info','TestController@userInfo');

Route::get('/test2','TestController@test2');

//接口测试
Route::post('/user/reg','User\IndexController@reg');
//登录
Route::post('/user/login','User\IndexController@login');
//平台
Route::get('/user/center','User\IndexController@center');

