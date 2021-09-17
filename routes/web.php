<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Livewire\Users;
use \App\Http\Livewire\Packages;
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

Route::redirect('/','/login');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/user', Users::class)->name('user');
Route::middleware(['auth:sanctum', 'verified'])->get('/package', Packages::class)->name('package');
// Route::get('/', function () {
//     return view('dashboard');
//     Route::get('user', User::class)->name('user');
//     Route::get('package', Package::class)->name('package');
// })->name('dashboard');