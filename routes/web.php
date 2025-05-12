<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
  return redirect('/login'); // Redireciona para a página de login
});

Route::get('/login', function () {
  return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login'); // Rota para autenticação

Route::resource('financeiros', FinanceiroController::class);
Route::get('/financeiros/{id}/edit', [FinanceiroController::class, 'edit'])->name('financeiros.edit');
Route::put('/financeiros/{id}', [FinanceiroController::class, 'update'])->name('financeiros.update');

Route::post('/logout', function () {
  // Aqui você pode implementar a lógica de logout, como limpar a sessão
  return redirect('/login');
})->name('logout');
