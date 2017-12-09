<?php

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

Route::post('/auth', 'Auth\LoginController@login');
Route::get('/get/categories', 'API\ApiCategoryController@get');
Route::get('/get/category/{id}/goods', 'API\ApiCategoryController@get_goods');

Route::middleware('api_auth')->group(function () {
    Route::post('/create/category', 'API\ApiCategoryController@create');
});