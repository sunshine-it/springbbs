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

// Route::get('/', function () {
//     return view('welcome');
// });

// 指定首页路由
Route::get('/', 'PagesController@root')->name('root');

Auth::routes(['verify' => true]);
// 等同下面路由 ------------：
// // 用户身份验证相关的路由
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// // 用户注册相关路由
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// // 密码重置相关路由
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// // Email 认证相关路由
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
// 等同下面路由 ------------：
// // 显示用户个人信息页面
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');
// // 显示编辑个人资料页面
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
// // 处理 edit 页面提交的更改
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update');

// 帖子
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
//  Slug 友好的 URL 显示 --参数表达式 {slug?}--? 意味着参数可选，这是为了兼容我们数据库中 Slug 为空的话题数据
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');
// 分类列表话题
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
// 上传图片
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
// 回复话题
Route::resource('replies', 'RepliesController', ['only' => ['store','destroy']]);
