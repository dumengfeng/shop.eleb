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
//Route::get('/', 'ShopsController@index');
Route::resource('shops', 'ShopsController');

Route::resource('user', 'UserController');
//Route::get('/users', 'UsersController@index')->name('users.index');//用户列表
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');//查看单个用户信息
//Route::get('/users/create', 'UsersController@create')->name('users.create');//显示添加表单
//Route::post('/users', 'UsersController@store')->name('users.store');//接收添加表单数据
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');//修改用户表单
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');//更新用户信息
//Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');//删除用户信息
Route::get('/', 'SessionsController@create')->name('Sessions.login');//显示登录页面

Route::post('/login', 'SessionsController@store')->name('up.login');//创建新会话（登录）
Route::get('/login', 'SessionsController@create')->name('login');//创建新会话（登录）
Route::delete('logout', 'SessionsController@destroy')->name('logout');//销毁会话（退出登录）
//修改密码
Route::get('/user/{user}/pwd','UserController@pwd')->name('user.pwd');//修改密码表单
Route::patch('/user/{user}/save', 'UserController@save')->name('user.save');//更新密码信息
//菜品分类
Route::resource('MenuCategories', 'MenuCategoryController');
//菜单
Route::resource('nu','MenuController');


Route::get('/MenuCategories/{MenuCategory}', 'MenuCategoryController@mr')->name('MenuCategories.mr');//默认
//接收图片上传路由
Route::post('upload',function (){
    $storage = \Illuminate\Support\Facades\Storage::disk('oss');
    $fileName = $storage->putFile('shops',request()->file('file'));
    return [
        'fileName'=>$storage->url($fileName),
    ];
})->name('upload');

//菜单
Route::resource('order','OrderController');

Route::any('order/{order}/ship','OrderController@ship')->name('order.ship');
Route::any('order/{order}/cancel','OrderController@cancel')->name('order.cancel');
//统计订单
Route::get('/count', 'OrderController@count')->name('order.count');//订单列表
Route::get('/count_day', 'OrderController@count_day')->name('order.count_day');//订单列表(日)
Route::get('/count_month', 'OrderController@count_month')->name('order.count_month');//订单列表(月)
//统计菜品
Route::get('/mc', 'MenuController@count')->name('nu.mc');//订单列表
Route::get('/mc_day', 'MenuController@count_day')->name('nu.mc_day');//订单列表(日)
Route::get('/mc_month', 'MenuController@count_month')->name('nu.mc_month');//订单列表(月)