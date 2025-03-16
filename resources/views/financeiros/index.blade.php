@extends('layouts.app')

@section('content')
<!-- Se o jQuery já estiver incluído no layout, remova essa linha -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h2 class="mb-0">Financeiro Pessoal</h2>
            <a href="{{ route('financeiros.create') }}" class="btn btn-light">Novo Registro</a>
        </div>
        <div class="card-body">
            <!-- Totais exibidos se necessário -->
            <div class="row mb-3">
                <div class="col">
                    <h5>Total À Pagar: <span id="total-a-pagar">R$ 0,00</span></h5>
                </div>
                <div class="col">
                    <h5>Total Pago: <span id="total-pago">R$ 0,00</span></h5>
                </div>
            </div>

            <!-- Tabela de registros -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Descrição</th>
                            <th>Mês Ant.</th>
                            <th>À Pagar (R$)</th>
                            <th>Pago (R$)</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-financeiros">
                        @foreach($financeiros as $fin)
                        <tr id="linha-{{ $fin->id }}">
                            <td>{{ $fin->descricao }}</td>
                            <td>0</td> {{-- Placeholder para "Mês Ant." --}}
                            <td class="valor-a-pagar">R$ {{ number_format($fin->a_pagar, 2, ',', '.') }}</td>
                            <td class="valor-pago">R$ {{ number_format($fin->pago ?? 0, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('financeiros.edit', $fin->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <button class="btn btn-danger btn-sm btn-excluir" data-id="{{ $fin->id }}">Excluir</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Formulário AJAX para novo registro -->
            <form id="form-novo-registro" class="mt-4">
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
                <button type="submit" class="btn btn-success">Salvar Registro</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        console.log("Document ready");

        // Função para atualizar totais
        function atualizarTotais() {
            let totalPagar = 0;
            let totalPago = 0;

            $(".valor-a-pagar").each(function() {
                let valor = parseFloat($(this).text().replace('R$ ', '').replace('.', '').replace(',', '.'));
                totalPagar += isNaN(valor) ? 0 : valor;
            });

            $(".valor-pago").each(function() {
                let valor = parseFloat($(this).text().replace('R$ ', '').replace('.', '').replace(',', '.'));
                totalPago += isNaN(valor) ? 0 : valor;
            });

            $("#total-a-pagar").text("R$ " + totalPagar.toLocaleString('pt-BR', {
                minimumFractionDigits: 2
            }));
            $("#total-pago").text("R$ " + totalPago.toLocaleString('pt-BR', {
                minimumFractionDigits: 2
            }));
        }

        atualizarTotais();

        // AJAX para inserir novo registro
        $("#form-novo-registro").submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('financeiros.store') }}",
                data: formData,
                success: function(response) {
                    let novoItem = `
                            <tr id="linha-${response.id}">
                                <td>${response.descricao}</td>
                                <td>0</td>
                                <td class="valor-a-pagar">R$ ${parseFloat(response.a_pagar).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                <td class="valor-pago">R$ ${parseFloat(response.pago ?? 0).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                <td>
                                    <a href="/financeiros/${response.id}/edit" class="btn btn-warning btn-sm">Editar</a>
                                    <button class="btn btn-danger btn-sm btn-excluir" data-id="${response.id}">Excluir</button>
                                </td>
                            </tr>
                        `;
                    $("#tabela-financeiros").append(novoItem);
                    atualizarTotais();
                    $("#form-novo-registro")[0].reset();
                },
                error: function(xhr) {
                    console.error("Erro ao inserir registro:", xhr);
                    alert('Erro ao adicionar registro.');
                }
            });
        });

        // AJAX para excluir registro
        $(document).on('click', '.btn-excluir', function(e) {
            e.preventDefault();
            console.log("Botão excluir clicado.");
            let id = $(this).data('id');
            if (!confirm("Tem certeza que deseja excluir este registro?")) return;

            $.ajax({
                url: `/financeiros/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $(`#linha-${id}`).fadeOut(500, function() {
                            $(this).remove();
                            atualizarTotais();
                        });
                        alert('Registro excluído com sucesso!');
                    } else {
                        alert('Erro ao excluir registro.');
                    }
                },
                error: function(xhr) {
                    console.error("Erro AJAX:", xhr);
                    alert('Erro ao excluir registro.');
                }
            });
        });
    });
</script>
@endsection