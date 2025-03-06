@extends('layouts.app')

@section('content')
    <h1>Editar Registro</h1>

    <form action="{{ route('financeiros.update', $financeiro->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Indica que estamos fazendo uma atualização -->

        <div>
            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" value="{{ old('descricao', $financeiro->descricao) }}" required>
        </div>

        <div>
            <label for="a_pagar">A Pagar:</label>
            <input type="number" name="a_pagar" value="{{ old('a_pagar', $financeiro->a_pagar) }}" required>
        </div>

        <div>
            <label for="pago">Pago:</label>
            <input type="number" name="pago" value="{{ old('pago', $financeiro->pago) }}">
        </div>

        <button type="submit">Salvar alterações</button>
    </form>
@endsection
