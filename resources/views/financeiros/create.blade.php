@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Novo Registro</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('financeiros.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="a_pagar" class="form-label">À Pagar (R$)</label>
                    <input type="number" name="a_pagar" id="a_pagar" class="form-control" required step="0.01">
                </div>
                <div class="mb-3">
                    <label for="pago" class="form-label">Pago (R$)</label>
                    <input type="number" name="pago" id="pago" class="form-control" step="0.01">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Salvar</button>
                    <a href="{{ route('financeiros.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection