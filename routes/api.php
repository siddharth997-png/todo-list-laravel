<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskApiController;
use App\Http\Controllers\AuthController;

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

//Public Routes
Route::get('/allTasks', [TaskApiController::class, 'fetchAllTasks']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/task', [TaskApiController::class, 'index']);
    Route::post('/task', [TaskApiController::class, 'store']);
    Route::get('/task/{task_id}', [TaskApiController::class, 'show']);
    Route::put('/task/{task_id}', [TaskApiController::class, 'update']);
    Route::delete('/task/{task_id}', [TaskApiController::class, 'destroy']);
    Route::get('/search', [TaskApiController::class, 'search']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
