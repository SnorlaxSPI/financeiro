<?php

namespace App\Http\Controllers;

use App\Models\Financeiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class FinanceiroController extends Controller
{
    public function index()
    {
        $financeiros = Financeiro::all();
        return view('financeiros.index', compact('financeiros'));
    }

    public function create()
    {
        return view('financeiros.create');
    }

    public function edit(string $id)
    {
        $financeiro = Financeiro::findOrFail($id);
        return view('financeiros.edit', compact('financeiro'));
    }

    public function store(Request $request)
    {
        Financeiro::create($request->validate([
            'descricao' => 'required',
            'a_pagar' => 'required|numeric',
            'pago' => 'nullable|numeric'
        ]));

        return redirect()->route('financeiros.index');
    }

    public function show(string $id)
    {
        //
    }

    // public function edit(string $id)
    // {
    //     //
    // }

    public function update(Request $request, string $id)
    {
        // Validação dos dados enviados no formulário
        $validatedData = $request->validate([
            'descricao' => 'required',
            'a_pagar' => 'required|numeric',
            'pago' => 'nullable|numeric'
        ]);

        // Busca o registro a ser atualizado
        $financeiro = Financeiro::findOrFail($id);

        // Atualiza os campos do registro
        $financeiro->update($validatedData);

        // Redireciona para a lista de registros
        return redirect()->route('financeiros.index')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        //
    }
}
