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

$router->get('/', function(){
    return response()->json(['message' => 'Connected to server'],200);
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
],  function(){
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
    }
);

Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'todo',
    'middleware' => ['auth:sanctum']
], function () {
        Route::get('/', 'TodoController@index');
        Route::post('add', 'TodoController@add');
        Route::post('update/{id}', 'TodoController@update');
        Route::delete('delete/{id}', 'TodoController@delete');
    }
);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

