<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TaskController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function()
{
    Route::get('profile_view',[TodoController::class,'profile_view']);
    Route::get('logout',[TodoController::class,'logout']);
    Route::post('add_task',[TaskController::class,'add_task']);
    Route::get('view_task',[TodoController::class,'view_task']);
    Route::get('users_task',[TodoController::class,'users_task']);
    Route::post('update_task/{task_id}',[TodoController::class,'update_task']);
    Route::post('delete_task/{task_id}',[TodoController::class,'delete_task']);
    // Route::get('select/{task_id}',[TodoController::class,'select']);
    Route::get('select',[TodoController::class,'select']);
    Route::get('select_joined',[TodoController::class,'select_joined']);


});
Route::post('create_user',[TodoController::class,'create_user']);
Route::get('view_user',[TodoController::class,'view_user']);
Route::post('login',[TodoController::class,'login']);
Route::post('image_add',[ImageController::class,'image_add']);
