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
        $validated = $request->validate([
            'descricao' => 'required',
            'a_pagar'   => 'required|numeric',
            'pago'      => 'nullable|numeric'
        ]);

        $financeiro = Financeiro::create($validated);

        if ($request->ajax()) {
            return response()->json($financeiro);
        }

        return redirect()->route('financeiros.index')->with('success', 'Registro criado com sucesso!');
    }

    public function show(string $id)
    {
        // Caso deseje implementar futuramente
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'descricao' => 'required',
            'a_pagar' => 'required|numeric',
            'pago' => 'nullable|numeric'
        ]);

        $financeiro = Financeiro::findOrFail($id);
        $financeiro->update($validatedData);

        return redirect()->route('financeiros.index')->with('success', 'Registro atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        try {
            $financeiro = Financeiro::findOrFail($id);
            $financeiro->delete();

            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('financeiros.index')->with('success', 'Registro excluído com sucesso!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Erro ao excluir o registro.']);
            }

            return redirect()->route('financeiros.index')->with('error', 'Erro ao excluir o registro.');
        }
    }
}
