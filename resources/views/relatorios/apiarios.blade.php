<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Apiários</title>
    <link href="{{ asset('css/pages/relatorios.css') }}" rel="stylesheet">
</head>
<body>

    <h1>Relatório de Apiários</h1>
    <h2>Responsável: {{ $pessoa->nome }}</h2>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Área (ha)</th>
                    <th>Data de Criação</th>
                    <th>Coordenadas</th>
                    <th>Qtd. Colmeias</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apiarios as $apiario)
                    <tr>
                        <td>{{ $apiario->nome }}</td>
                        <td>{{ number_format($apiario->area, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($apiario->data_criacao)->format('d/m/Y') }}</td>
                        <td>{{ $apiario->coordenadas ?? 'Não informado' }}</td>
                        <td>{{ $apiario->colmeias->count() }}</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <strong>Endereço:</strong>
                            {{ $apiario->enderecos->logradouro ?? '---' }}, Nº {{ $apiario->enderecos->numero ?? '---' }}
                            @if(!empty($apiario->enderecos->complemento))
                                , {{ $apiario->enderecos->complemento }}
                            @endif
                            - {{ $apiario->enderecos->bairro ?? '---' }},
                            {{ $apiario->enderecos->cidade ?? '---' }} - {{ $apiario->enderecos->estado ?? '--' }},
                            CEP: {{ $apiario->enderecos->cep ?? '--' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="small">Gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>

</body>
</html>
