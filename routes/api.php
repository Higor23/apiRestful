<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('auth', 'Auth\AuthApiController@authenticate');
Route::get('me', 'Auth\AuthApiController@getAuthenticatedUser');
Route::post('auth-refresh', 'Auth\AuthApiController@refreshToken');

Route::group([
    'prefix' => 'v1', 
    'namespace' => 'Api\v1',
    // 'middleware' => 'jwt.auth',
], function () {
    
    // Categories
    Route::get('categories', 'CategoryController@index')->name('categories');
    Route::post('categories/store', 'CategoryController@store')->name('categories.store');
    Route::put('categories/update/{id}', 'CategoryController@update')->name('category.update');
    Route::delete('categories/delete/{id}', 'CategoryController@delete')->name('categories.delete');
    Route::get('categories/show/{id}', 'CategoryController@show')->name('category.show');
    // Route::apiResource('categories', 'CategoryCOntroller'); // Desta forma, susbtitui todas as rotas do crud em uma única linha. Obs: o método é destroy() e não delete();

    // Products 

    Route::resource('products', 'ProductController');

    // Products by category 

    Route::get('categories/{id}/products', 'CategoryController@products');
});
