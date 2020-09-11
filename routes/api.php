<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Brand;
use App\Modele;
use App\Car;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group(array('prefix' => 'cars'), function() {
    Route::get('/list', function() {
        return Response::json(Car::searchAdminCar());
    });
    Route::get('/view', function(Request $request) {
        $data = $request->all();
        return Response::json(Car::FindCar(array("id" => $data['id']))); 
    });
    Route::post('/add', function(Request $request) {
        $data = $request->all();
        return Response::json(Car::addCar($data));
    });
    Route::post('/edit', function(Request $request) {
        $data = $request->all();
        return Response::json(Car::editCar($data));
    });
    Route::post('/delete', function(Request $request) {
        $data = $request->all();
        return Response::json(Car::deleteCar($data));
    });
});
Route::group(array('prefix' => 'brand'), function() {
    Route::get('/', function() {
        return Response::json(Brand::listBrand());
    });
    Route::get('/list', function(Request $request) {
        $data = $request->all();
        return Response::json(Modele::getListModelByBrand(array("idbrand" => $data['idbrand'], 'select' => TRUE)));
    });
});
Route::get('/model', function() {
    return Response::json(Modele::allModele());
});