<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::get('/', HomeController::class)->name('home');
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('rents', function () {
        return view('back.index', ['title' => 'Mes réservations']);
    })->name('rents');
    Route::get('payments', function () {
        return view('back.index', ['title' => 'Mes paiements']);
    })->name('payments');
});