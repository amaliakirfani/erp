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
        });

        Route::group(['prefix' => '/jabatan'], function () {
            Route::get('/', 'JabatanController@index');
            Route::get('/json', 'JabatanController@indexJson');
            Route::post('/create/json', 'JabatanController@createJson');
        });
    });
});
