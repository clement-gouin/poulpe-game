<?php

use App\Models\Player;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('dashboard.index');
});

Route::get('/players', function() {
    return Player::query()->orderBy('id')->get();
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'show'])->name('admin');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::get('/update/{id}', [AdminController::class, 'update'])->name('update');
    Route::get('/create/{any}', [AdminController::class, 'create']);
    Route::post('/create/{id}', [AdminController::class, 'store'])->name('store');
    Route::get('/switch/{id}', [AdminController::class, 'switch'])->name('switch');
    Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('delete');
});
