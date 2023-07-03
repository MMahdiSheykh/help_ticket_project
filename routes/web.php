<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::resource('/ticket',TicketController::class);
//    Route::get('ticket/index',[TicketController::class,'index'])->name('ticket.index');
//    Route::get('ticket/create',[TicketController::class,'create'])->name('ticket.create');
//    Route::post('ticket/store',[TicketController::class,'store'])->name('ticket.store');
//    Route::post('ticket/show',[TicketController::class,'show'])->name('ticket.show');
//    Route::post('ticket/edit',[TicketController::class,'edit'])->name('ticket.edit');
//    Route::post('ticket/update',[TicketController::class,'update'])->name('ticket.update');
//    Route::post('ticket/destroy',[TicketController::class,'destroy'])->name('ticket.destroy');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
