<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('dashboard');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');


Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/role', 'RoleController@create')->name('chuc_vu');
    Route::post('/add_role', 'RoleController@store')->name('xu_li');

    Route::get('/permission', 'PermissionController@create')->name('quyen');
    Route::post('/add_permission', 'PermissionController@store')->name('xu_li_them_quyen');

    Route::get('/add_permission_to_role', 'RoleController@viewAddPermissionToRole')->name('them_quyen_cho_chuc_vu');
    Route::post('/process_add_permission_to_role', 'RoleController@addPermissionToRole')->name('xu_li_them_quyen_cho_chuc_vu');

    Route::get('/add_staff', 'UserController@create')->name('them_nhan_vien');
    Route::post('/process_add_staff', 'UserController@store')->name('xu_li_them_nhan_vien');

    Route::get('/role', 'RoleController@create')->name('chuc_vu');
    Route::post('/add_role', 'RoleController@store')->name('xu_li');

    Route::get('/role_permission_detail', 'RoleController@index')->name('quyen_chi_tiet');

    Route::get('/permission', 'PermissionController@create')->name('quyen');
    Route::post('/add_permission', 'PermissionController@store')->name('xu_li_them_quyen');

    Route::get('/add_permission_to_role', 'RoleController@viewAddPermissionToRole')->name('them_quyen_cho_chuc_vu');
    Route::post('/process_add_permission_to_role', 'RoleController@addPermissionToRole')->name('xu_li_them_quyen_cho_chuc_vu');

    Route::get('/add_staff', 'UserController@create')->name('them_nhan_vien');
    Route::post('/process_add_staff', 'UserController@store')->name('xu_li_them_nhan_vien');
});

Route::group(['middleware' => ['permission:publish articles']], function () {
    //
});

Route::group(['middleware' => ['role:super-admin', 'permission:publish articles']], function () {
    //
});

Route::group(['middleware' => ['role_or_permission:super-admin|edit articles']], function () {
    //
});

Route::group(['middleware' => ['role_or_permission:publish articles']], function () {
    //
});
