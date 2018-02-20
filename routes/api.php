<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('brands', 'ApiController@brands');
Route::post('sets', 'ApiController@sets');
Route::post('locales', 'ApiController@locales');
Route::post('categories', 'ApiController@categories');
Route::post('properties', 'ApiController@properties');
Route::post('attributes', 'ApiController@attributes');
Route::post('save-products', 'ApiController@saveProducts');