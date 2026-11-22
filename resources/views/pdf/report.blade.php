<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Relatório de vendas</title>
    <style>
        @page { margin: 30px 35px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; }
        h1 { font-size: 18px; margin: 0 0 4px 0; }
        h2 { font-size: 13px; margin: 18px 0 4px 0; color: #2b4c7e; }
        .muted { color: #666; font-size: 10px; }
        .header { border-bottom: 2px solid #2b4c7e; padding-bottom: 10px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 4px; }
        th { background: #f0f0f0; text-align: left; padding: 6px; border: 1px solid #ccc; }
        td { padding: 6px; border: 1px solid #ccc; }
        .right { text-align: right; }
        .summary td { font-size: 12px; }
        .footer { margin-top: 25px; font-size: 9px; color: #888; text-align: center; border-top: 1px solid #ddd; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de vendas</h1>
        <div class="muted">
            Período: {{ $start->format('d/m/Y') }} a {{ $end->format('d/m/Y') }}
            &nbsp;|&nbsp; Gerado em {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <h2>Resumo</h2>
    <table class="summary">
        <tr>
            <td><strong>Vendas faturadas:</strong> {{ $summary['orders_count'] }}</td>
            <td><strong>Faturamento:</strong> R$ {{ number_format($summary['revenue'], 2, ',', '.') }}</td>
            <td><strong>Ticket médio:</strong> R$ {{ number_format($summary['average_ticket'], 2, ',', '.') }}</td>
        </tr>
    </table>

    <h2>Vendas por dia</h2>
    <table>
        <thead>
            <tr><th>Dia</th><th class="right">Pedidos</th><th class="right">Faturamento</th></tr>
        </thead>
        <tbody>
            @forelse ($salesByDay as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->day)->format('d/m/Y') }}</td>
                    <td class="right">{{ $row->orders_count }}</td>
                    <td class="right">R$ {{ number_format($row->revenue, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Nenhuma venda no período.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Produtos mais vendidos</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Produto</th><th class="right">Qtd. vendida</th><th class="right">Faturamento</th></tr>
        </thead>
        <tbody>
            @forelse ($topProducts as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td class="right">{{ $row->total_quantity }}</td>
                    <td class="right">R$ {{ number_format($row->total_revenue, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Nenhum produto vendido no período.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Pedidos por status (criados no período)</h2>
    <table>
        <thead>
            <tr><th>Status</th><th class="right">Pedidos</th><th class="right">Valor total</th></tr>
        </thead>
        <tbody>
            @foreach ($ordersByStatus as $row)
                <tr>
                    <td>{{ $row['status']->label() }}</td>
                    <td class="right">{{ $row['orders_count'] }}</td>
                    <td class="right">R$ {{ number_format($row['amount'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Documento gerado para fins acadêmicos.</div>
</body>
</html>
