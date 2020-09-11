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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', 'CarController@ListCarAdminPage');

Route::get('/model/list', 'ModeleController@getListModelByBrand');

Route::group(array('prefix' => '/admin'), function() {

    Route::group(array('prefix' => '/car'), function() {
        Route::get('/', 'CarController@ListCarAdminPage');
        Route::get('/view', 'CarController@viewCarAdminPage');
        Route::get('/edit', 'CarController@editCarAdminPage');
        Route::post('/edit', 'CarController@editCarAdmin');
        Route::post('/delete', 'CarController@deleteCarAdmin');
        Route::get('/add', 'CarController@addCarAdminPage');
        Route::post('/add', 'CarController@addCar');
        Route::post('/search', 'CarController@SearchAdminCars');
    });
    Route::group(array('prefix' => '/brand'), function() {
        Route::get('/', 'BrandController@ListBrandAdminPage');
        Route::get('/add', 'BrandController@addBrandAdminPage');
        Route::post('/add', 'BrandController@addBrand');
        Route::get('/{id}/edit', 'BrandController@editBrandAdminPage');
        Route::post('/edit', 'BrandController@editBrandAdmin');
        Route::post('/delete', 'BrandController@deleteBrandAdmin'); 
    });
    Route::group(array('prefix' => '/model'), function() {
        Route::get('/', 'ModeleController@ListModeleAdminPage');
        Route::get('/add', 'ModeleController@addModeleAdminPage');
        Route::post('/add', 'ModeleController@addModele');
        Route::get('/{id}/edit', 'ModeleController@editModelAdminPage');
        Route::post('/edit', 'ModeleController@editModelAdmin');
        Route::post('/delete', 'ModeleController@deleteModelAdmin');
    });
});


