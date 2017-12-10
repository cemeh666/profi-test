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

Route::post('/auth',                'Auth\LoginController@login');
Route::get('/categories',           'API\ApiCategoryController@get');
Route::get('/category/{id}/goods',  'API\ApiCategoryController@get_goods');

Route::middleware('api_auth')->group(function () {
    //создание
    Route::post('/category', 'API\ApiCategoryController@create');
    Route::post('/goods',    'API\ApiGoodsController@create');
    //изменение
    Route::put('/goods/{id}',    'API\ApiGoodsController@edit');
    Route::put('/category/{id}', 'API\ApiCategoryController@edit');
    //удаление
    Route::delete('/goods/{id}',    'API\ApiGoodsController@delete');
    Route::delete('/category/{id}', 'API\ApiCategoryController@delete');

});