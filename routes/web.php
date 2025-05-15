<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
  return redirect('/login');
});

Route::get('/login', function () {
  return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas por middleware 'auth'
Route::middleware('auth')->group(function () {
  Route::resource('financeiros', FinanceiroController::class);
  Route::get('/financeiros/{id}/edit', [FinanceiroController::class, 'edit'])->name('financeiros.edit');
  Route::put('/financeiros/{id}', [FinanceiroController::class, 'update'])->name('financeiros.update');

  Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
  })->name('logout');
});
