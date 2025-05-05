<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceiroController;

Route::get('/login', function () {
  return view('auth.login');
});

Route::redirect('/', '/financeiros');
Route::resource('financeiros', FinanceiroController::class);
Route::get('/financeiros/{id}/edit', [FinanceiroController::class, 'edit'])->name('financeiros.edit');
Route::put('/financeiros/{id}', [FinanceiroController::class, 'update'])->name('financeiros.update');
