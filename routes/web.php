<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\TransfersController as AdminTransfersController;
use App\Http\Controllers\Admin\DepositsController as AdminDepositsController;
use App\Http\Controllers\Indexer\AccountsController as IndexerAccountsController;
use App\Http\Controllers\Indexer\AssetsController as IndexerAssetsController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\WalletsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Indexer\IndexerController;
use App\Http\Controllers\TransactionsController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Autenticação
 */
Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    Route::get('login', '\Autum\SAML\Http\Controllers\Auth\SamlController@login')->middleware(['guest:'.config('fortify.guard')])->name('login');
    Route::get('logout', '\Autum\SAML\Http\Controllers\Auth\SamlController@logout')->name('logout');
});

Route::group([
    'middleware' => ['auth:sanctum', 'verified'],
], function(){
    Route::get('/dashboard', function() {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::group([
    //
], function(){
    Route::get('/', function() {
        return Inertia::render('Home');
    })->name('home');
});

Route::group([
    'middleware' => ['auth:sanctum', 'verified'],
    'prefix' => 'contacts',
    'as' => 'contacts.'
], function(){
    Route::get('/', [ContactsController::class, 'index'])->name('index');
    Route::get('/create', [ContactsController::class, 'create'])->name('create');
    Route::post('/', [ContactsController::class, 'store'])->name('store');
    Route::get('/{contact}', [ContactsController::class, 'show'])->name('show');
    Route::put('/{contact}', [ContactsController::class, 'update'])->name('update');
    Route::delete('/{contact}', [ContactsController::class, 'destroy'])->name('destroy');
});

Route::group([
    'middleware' => ['auth:sanctum', 'verified', 'admin'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function(){
    Route::get('/', [UsersController::class, 'index'])->name('dashboard');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
});