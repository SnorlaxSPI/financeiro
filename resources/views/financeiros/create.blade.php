@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Novo Registro</h2>
        <form action="{{ route('financeiros.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" name="descricao" required>
            </div>
            <div class="mb-3">
                <label for="a_pagar" class="form-label">À Pagar</label>
                <input type="number" class="form-control" name="a_pagar" required step="0.01">
            </div>
            <div class="mb-3">
                <label for="pago" class="form-label">Pago</label>
                <input type="number" class="form-control" name="pago" step="0.01">
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </div>
@endsection
