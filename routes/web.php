<?php

use Illuminate\Support\Facades\Route;
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'Admin\AdminController@index')->name('admin');
Route::get('/admin/create', 'Admin\AdminController@create')->name('createEmail');
Route::post('/admin/store', 'Admin\AdminController@store');
Route::get('/admin/{user}/show', 'Admin\AdminController@show');

Route::get('/admin/{user}/edit', 'Admin\AdminController@edit');
Route::post('/admin/{user}/update-user', 'Admin\AdminController@update');

Route::get('/admin/{user}/delete', 'Admin\AdminController@destroy');

Route::get('/admin/search', 'Admin\AdminController@search');

Route::get('/admin/{user}/role/setAdmin', 'Admin\SuperAdminController@setAdmin');
Route::get('/admin/{user}/role/setViewer', 'Admin\SuperAdminController@setViewer');
Route::get('/admin/{user}/role/blocked', 'Admin\SuperAdminController@blockUser');
