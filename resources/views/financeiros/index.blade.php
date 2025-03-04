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
                </tr>
            </thead>
            <tbody id="tabela-financeiros">
                @foreach($financeiros as $fin)
                    <tr>
                        <td>{{ $fin->descricao }}</td>
                        <td>{{ $fin->mes_anterior }}</td>
                        <td class="valor-a-pagar">R$ {{ number_format($fin->a_pagar, 2, ',', '.') }}</td>
                        <td class="valor-pago">R$ {{ number_format($fin->pago, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td><strong id="total-a-pagar">R$ {{ number_format($financeiros->sum('a_pagar'), 2, ',', '.') }}</strong></td>
                    <td><strong id="total-pago">R$ {{ number_format($financeiros->sum('pago'), 2, ',', '.') }}</strong></td>
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
                            <tr>
                                <td>${response.descricao}</td>
                                <td>0</td>
                                <td class="valor-a-pagar">R$ ${parseFloat(response.a_pagar).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                <td class="valor-pago">R$ ${parseFloat(response.pago ?? 0).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                            </tr>
                        `;

                        $("#tabela-financeiros").append(novoItem);
                        atualizarTotais();
                    }
                });
            });
        });
    </script>
@endsection
