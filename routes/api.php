<?php

use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['auth:sanctum', 'verified'],
    'prefix' => 'account',
    'as' => 'api.account.'
], function(){
    Route::get('/', [UserController::class, 'show'])->name('show');
    Route::get('/limits', [UserController::class, 'limits'])->name('limits');
    Route::put('/', [UserController::class, 'update'])->name('update');
});


Route::group([
    'middleware' => ['auth:sanctum', 'verified'],
    'prefix' => 'admin',
    'as' => 'api.admin.'
], function(){

    //
});