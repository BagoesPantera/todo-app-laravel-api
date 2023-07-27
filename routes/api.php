<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

$router->get('/', function(){
    return response()->json(['message' => 'Connected to server'],200);
});

// auth group
Route::prefix('auth')->controller(AuthController::class)->group(function (){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'todo',
    'middleware' => ['auth:sanctum']
], function () {
        
    }
);

// todo group
Route::prefix('todo')->controller(TodoController::class)->middleware('auth:sanctum')->group(function (){
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('add', 'add');
    Route::post('update/{id}', 'update');
    Route::delete('delete/{id}', 'delete');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
