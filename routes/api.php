<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/sign-up', [UserController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['apiJwt']], function(){
    Route::get('users', [UserController::class, 'index']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('/items', [ItemController::class, 'index']);
    Route::prefix('/item')->group(function(){
        Route::post('/store',[ItemController::class, 'store']);
        Route::put('/{id}' , [ItemController::class, 'update']);
        Route::delete('/{id}', [ItemController::class, 'destroy'] );
    });
});

