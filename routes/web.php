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
Route::get('/index',function (){
    return view('Index.index');
});
//商家简单表和详情表的增删该查
Route::resource('shops','BusinessController');
//商家登录注销
Route::get('/login','SessionController@login')->name('login');
Route::post('/login','SessionController@store');
Route::delete('/logout','SessionController@logout')->name('logout');
//商家菜品分类的增删改查
Route::resource('fcategories','Food_CategoryController');
//商家对菜品的增删改查
Route::resource('dishs','DishesController');

