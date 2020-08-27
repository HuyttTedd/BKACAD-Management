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
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'HomeController@index')->name('dashboard');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::group(['prefix' => 'role_permission'], function () {
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

        });
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::group(['prefix' => 'staff'], function () {
            Route::get('/add_staff', 'UserController@create')->name('them_nhan_vien');
            Route::post('/process_add_staff', 'UserController@store')->name('xu_li_them_nhan_vien');

            Route::get('/list_staff', 'UserController@index')->name('danh_sach_nhan_vien');
        });
    });

    Route::group(['middleware' => ['role:admin|ministry']], function () {
        Route::group(['prefix' => 'course_major'], function () {
            Route::get('/create_course', 'CourseController@create')->name('them_khoa');
            Route::post('/process_create_course', 'CourseController@store')->name('xu_li_them_khoa');
            Route::get('/view_course', 'CourseController@index')->name('xem_khoa');

            Route::get('/create_major', 'MajorController@create')->name('them_nganh');
            Route::post('/process_create_major', 'MajorController@store')->name('xu_li_them_nganh');
            Route::get('/view_major', 'MajorController@index')->name('xem_nganh');

            Route::get('/add_major_to_course', 'CourseController@viewAddMajorToCourse')->name('them_nganh_cho_khoa');
            Route::post('/process_add_major_to_course', 'CourseController@addMajorToCourse')->name('xu_li_them_nganh_cho_khoa');
            Route::get('/view_course_detail', 'CourseController@showDetails')->name('khoa_chi_tiet');
            Route::get('/{id}/update_subject_to_major', 'MajorController@viewUpdateSubjectToMajor')->name('cap_nhap_mon_cho_nganh');
            Route::get('/{id}/update_major_for_course', 'CourseController@viewUpdateMajorToCourse')->name('cap_nhap_nganh_cho_khoa');

        });

        Route::group(['prefix' => 'subject'], function () {
            Route::get('/add_subject', 'SubjectController@create')->name('them_mon');
            Route::post('/process_add_subject', 'SubjectController@store')->name('xu_li_them_mon');
            Route::get('/view_subject', 'SubjectController@index')->name('xem_mon');

            Route::get('/add_subject_to_major', 'MajorController@viewAddSubjectToMajor')->name('them_mon_cho_nganh');
            Route::post('/process_add_subject_to_major', 'MajorController@addSubjectToMajor')->name('xu_li_them_mon_cho_nganh');
            Route::get('/view_subject_of_major', 'MajorController@showSubjectOfMajor')->name('xem_mon_cua_nganh');

            Route::post('/showCourseMajor', 'MajorController@showCourseMajor')->name('show_course_major');

        });

        Route::group(['prefix' => 'student'], function () {
            Route::get('/import_student', 'StudentController@import')->name('nhap_sinh_vien');
            Route::post('/process_import_student', 'StudentController@storeImport')->name('xu_li_nhap_sinh_vien');
        });
    });
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
