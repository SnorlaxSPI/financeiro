<?php

namespace App\Http\Controllers;

use App\Models\Financeiro;
use Illuminate\Http\Request;

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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
