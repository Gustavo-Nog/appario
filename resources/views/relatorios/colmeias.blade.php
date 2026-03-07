<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Apiários</title>
    <link href="{{ asset('css/pages/relatorios.css') }}" rel="stylesheet">
</head>
<body>

    <h1>Relatório de colmeias</h1>
    @if ($pessoa)
        <h2>Responsável: {{ $pessoa->nome }}</h2>
    @else
        <h2>Responsável: Não informado</h2>
    @endif

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Especie</th>
                    <th>Tamanho</th>
                    <th>Data de Aquisição</th>
                    <th>Apiario Vinculado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colmeias as $colmeia)
                    <tr>
                        <td>{{ $colmeia->especie }}</td>
                        <td>{{ $colmeia->tamanho }}</td>
                        <td>{{ \Carbon\Carbon::parse($colmeia->data_aquisicao)->format('d/m/Y') }}</td>
                        <td>{{ $colmeia->apiario->nome ?? 'Nenhum encontrado' }}</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <strong>Endereço do Apiario:</strong>
                            {{ $colmeia->apiario->enderecos->logradouro ?? '---' }}, Nº {{ $colmeia->apiario->enderecos->numero ?? '---' }}
                            @if(!empty($colmeia->apiario->enderecos->complemento))
                                , {{ $colmeia->apiario->enderecos->complemento }}
                            @endif
                            - {{ $colmeia->apiario->enderecos->bairro ?? '---' }},
                            {{ $colmeia->apiario->enderecos->cidade ?? '---' }} - {{ $colmeia->apiario->enderecos->estado ?? '--' }},
                            CEP: {{ $colmeia->apiario->enderecos->cep ?? '--' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="small">Gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>

</body>
</html>
