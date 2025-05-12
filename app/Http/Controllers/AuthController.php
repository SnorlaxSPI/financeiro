<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    // Verifica se o email e senha estão corretos
    if ($credentials['email'] === 'aflinsjr@gmail.com' && $credentials['password'] === '123mudar') {
      return redirect('/financeiros'); // Redireciona para a tela do financeiro
    }

    // Retorna erro se as credenciais forem inválidas
    return back()->withErrors(['email' => 'Credenciais inválidas.']);
  }
}
