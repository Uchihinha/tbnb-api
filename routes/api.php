<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->group(function($router) {
    $router->get('{id}/history', 'ProductController@getStockHistory');
    $router->put('bulk', 'ProductController@bulkUpdate');

    $router->post('', 'ProductController@create');
    $router->get('', 'ProductController@get');
    $router->put('{id}', 'ProductController@update');
    $router->get('{id}', 'ProductController@find');
    $router->delete('{id}', 'ProductController@delete');
});
