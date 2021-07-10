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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::group(['prefix' => '/', 'namespace' => 'App\Http\Controllers'], function () {
    Route::get("/", 'HomeController@index');

    Route::group(['prefix' => '/master','namespace' => 'Master'], function () {
        Route::group(['prefix' => '/divisi'], function () {
            Route::get('/', 'DivisiController@index');
            Route::get('/json', 'DivisiController@indexJson');
            Route::post('/create/json', 'DivisiController@createJson');
            Route::get('/edit/{id}/json', 'DivisiController@editJson');
            Route::post('/update/json', 'DivisiController@updateJson');
            Route::get('/delete/{id}/json', 'DivisiController@deleteJson');
        });

        Route::group(['prefix' => '/jabatan'], function () {
            Route::get('/', 'JabatanController@index');
            Route::get('/json', 'JabatanController@indexJson');
            Route::post('/create/json', 'JabatanController@createJson');
            Route::get('/edit/{id}/json', 'JabatanController@editJson');
            Route::post('/update/json', 'JabatanController@updateJson');
            Route::get('/delete/{id}/json', 'JabatanController@deleteJson');
        });

        Route::group(['prefix' => '/karyawan'], function () {
            Route::get('/', 'KaryawanController@index');
            Route::get('/json', 'KaryawanController@indexJson');
            Route::post('/create/json', 'KaryawanController@createJson');
            Route::get('/edit/{id}/json', 'KaryawanController@editJson');
            Route::post('/update/json', 'KaryawanController@updateJson');
            Route::get('/delete/{id}/json', 'KaryawanController@deleteJson');
        });

        Route::group(['prefix' => '/salary'], function () {
            Route::get('/', 'SalaryController@index');
            Route::get('/json', 'SalaryController@indexJson');
            Route::post('/create/json', 'SalaryController@createJson');
            Route::get('/edit/{id}/json', 'SalaryController@editJson');
            Route::post('/update/json', 'SalaryController@updateJson');
            Route::get('/delete/{id}/json', 'SalaryController@deleteJson');
        });
    });

    Route::group(['prefix' => '/attendance'], function () {
        Route::get('/', 'AttendanceController@index');
        Route::get('/json', 'AttendanceController@indexJson');
        Route::post('/create/json', 'AttendanceController@createJson');
    });

    Route::group(['prefix' => '/salaries'], function () {
        Route::get('/', 'SalariesController@index');
        Route::get('/json', 'SalariesController@indexJson');
        Route::post('/detail/json', 'SalariesController@detailJson');
    });
});
