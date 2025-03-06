<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceiroController;

Route::resource('financeiros', 'App\Http\Controllers\FinanceiroController');
Route::get('/financeiros/{id}/edit', [FinanceiroController::class, 'edit'])->name('financeiros.edit');
Route::put('/financeiros/{id}', [FinanceiroController::class, 'update'])->name('financeiros.update');

