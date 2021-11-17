<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('register', 'AuthController@register');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

// configuration rutes
    Route::apiResource('users','UserController');
    Route::apiResource('roles','RoleController');
    Route::apiResource('cities','CityController');
    Route::apiResource('regions','RegionController');
    Route::apiResource('exercices','ExerciceController');
    Route::apiResource('fournisseurs','FournisseurController');
    Route::apiResource('familles','FamilleController');
    Route::apiResource('services','ServiceController');
    Route::apiResource('unities','UnityController');
    Route::apiResource('currencies','CurrencyController');

    // entry routes
    Route::apiResource('entries','EntryController');


    // products
    Route::apiResource('products','ProductController');
    Route::get('/products/{id}/entries','EntryController@entriesByProduct');

    // fournisseurs
    Route::get('/fournisseurs/{id}/entries','EntryController@entriesByFournisseur');

    // Stocks 
    Route::get('stocks','StockController@index');
    Route::get('stocks/{stock}','StockController@show');


    // Sorties 

    Route::get('sorties','SortieController@index');



   





