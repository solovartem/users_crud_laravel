<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;

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

Route::get('/v1/users', [UserController::class, 'index']);
Route::post('/v1/user/create', [UserController::class, 'store']);
Route::get('/v1/user/edit/{id}', [UserController::class, 'edit']);
Route::post('/v1/user/update/{id}', [UserController::class, 'update']);
Route::delete('/v1/user/delete/{id}', [UserController::class, 'delete']);