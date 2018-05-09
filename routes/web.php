<?php

Route::get('/index',function (){
    return view('Index.index');
});
//商家简单表和详情表的增删该查
Route::resource('shops','BusinessController');
//商家登录注销
Route::get('/','SessionController@login')->name('login');
Route::post('/login','SessionController@store');
Route::delete('/logout','SessionController@logout')->name('logout');
//商家菜品分类的增删改查
Route::resource('fcategories','Food_CategoryController');
//商家对菜品的增删改查
Route::resource('dishs','DishesController');
//Route::get('/test', function()
//{
//    $client = App::make('aliyun-oss');
//    $client->putObject("zhou-laravel-shop", "1.txt", "hello.laozhou");
//    $result = $client->getObject("zhou-laravel-shop", "1.txt");
//    echo $result;
//});
Route::post('/upload','UploadController@upload');
//商户点击产看平台所有活动
Route::get('/activity','ActivityController@index');
//商户点击查看某个活动详情
Route::get('/show','ActivityController@show')->name('activity.show');
//商户对订单的操作,取消订单,发货,  状态1 已发货 0 未发货===取消发货
Route::resource('orders','OrderController');
//商户按天搜索
Route::post('/daycount','OrderController@dayCount')->name('dayCount');
//商户按范围搜索 ,表单展示
Route::get('/dayWidthCount','OrderController@dayWidthCount')->name('dayWidthCount');
//商户按范围搜索,处理
Route::post('/dayWidthCount','OrderController@dayWidthCountDeal')->name('dayWidthNum');
//
Route::post('/monthcount','OrderController@monthCount')->name('monthCount');
Route::post('/allcount','OrderController@allCount')->name('allCount');
//商家菜品销量统计
Route::get('/dishCount','OrderController@dishCount');
//
Route::post('/dishCount','OrderController@timeCount');
//用户查看抽奖活动列表
Route::get('/event.index','EventController@index')->name('event.index');
//用户查看/活动详情
Route::get('/event.show','EventController@show')->name('event.show');
//用户点击参与活动
Route::get('/event.join','EventController@join')->name('event.join');
//查看奖品列表
Route::get('/prize.index','PrizeController@index')->name('prize.index');
//查看某个活动开奖结果
Route::get('/result','EventController@result');
//Route::get('/test',function (){
//    \Illuminate\Support\Facades\Mail::send(
//        'Mail.mail',
//        ['name'=>'张三'],
//        function ($message){
//            $message->to('592752707@qq.com')->subject('注册确认');
//        }
//    );
//    return 'success';
//});
