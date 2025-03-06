@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Financeiro Pessoal</h2>
        <a href="{{ route('financeiros.create') }}" class="btn btn-primary">Novo Registro</a>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>DESCRIÇÃO</th>
                    <th>MÊS ANT.</th>
                    <th>À PAGAR</th>
                    <th>PAGO</th>
                    <th>AÇÕES</th> <!-- Nova coluna para ações -->
                </tr>
            </thead>
            <tbody id="tabela-financeiros">
                @foreach($financeiros as $fin)
                    <tr id="linha-{{ $fin->id }}">
                        <td>{{ $fin->descricao }}</td>
                        <td>{{ $fin->mes_anterior }}</td>
                        <td class="valor-a-pagar">R$ {{ number_format($fin->a_pagar, 2, ',', '.') }}</td>
                        <td class="valor-pago">R$ {{ number_format($fin->pago, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('financeiros.edit', $fin->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                            <button class="btn btn-danger btn-sm btn-excluir" data-id="{{ $fin->id }}">🗑 Excluir</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td><strong id="total-a-pagar">R$ {{ number_format($financeiros->sum('a_pagar'), 2, ',', '.') }}</strong></td>
                    <td><strong id="total-pago">R$ {{ number_format($financeiros->sum('pago'), 2, ',', '.') }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Adicionando AJAX para atualizar os totais automaticamente --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Função para atualizar os totais
            function atualizarTotais() {
                let totalPagar = 0;
                let totalPago = 0;

                $(".valor-a-pagar").each(function () {
                    totalPagar += parseFloat($(this).text().replace('R$ ', '').replace('.', '').replace(',', '.'));
                });

                $(".valor-pago").each(function () {
                    totalPago += parseFloat($(this).text().replace('R$ ', '').replace('.', '').replace(',', '.'));
                });

                $("#total-a-pagar").text("R$ " + totalPagar.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
                $("#total-pago").text("R$ " + totalPago.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
            }

            // Atualiza totais ao carregar a página
            atualizarTotais();

            // AJAX para inserir um novo registro sem recarregar
            $("#form-novo-registro").submit(function (e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route('financeiros.store') }}",
                    data: formData,
                    success: function (response) {
                        let novoItem = `
                            <tr id="linha-${response.id}">
                                <td>${response.descricao}</td>
                                <td>0</td>
                                <td class="valor-a-pagar">R$ ${parseFloat(response.a_pagar).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                <td class="valor-pago">R$ ${parseFloat(response.pago ?? 0).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                <td>
                                    <a href="/financeiros/${response.id}/edit" class="btn btn-warning btn-sm">✏️ Editar</a>
                                    <button class="btn btn-danger btn-sm btn-excluir" data-id="${response.id}">🗑 Excluir</button>
                                </td>
                            </tr>
                        `;

                        $("#tabela-financeiros").append(novoItem);
                        atualizarTotais();
                    }
                });
            });

            // AJAX para excluir um registro sem recarregar
            $(document).on("click", ".btn-excluir", function () {
                let id = $(this).data("id");
                if (!confirm("Tem certeza que deseja excluir este registro?")) return;

                $.ajax({
                    type: "DELETE",
                    url: `/financeiros/${id}`,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function () {
                        $("#linha-" + id).remove();
                        atualizarTotais();
                    }
                });
            });
        });
    </script>
@endsection
