<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    // Valida os dados do formulário
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    // Tenta autenticar o usuário
    if (Auth::attempt($request->only('email', 'password'))) {
      // Redireciona para a tela do financeiro se as credenciais forem válidas
      return redirect('/financeiros');
    }

    // Retorna erro se as credenciais forem inválidas
    return back()->withErrors(['email' => 'Credenciais inválidas.']);
  }
}
