<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Pedido #{{ $order->id }}</title>
    <style>
        @page { margin: 30px 35px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; }
        h1 { font-size: 18px; margin: 0 0 4px 0; }
        .muted { color: #666; }
        .header { border-bottom: 2px solid #2b4c7e; padding-bottom: 10px; margin-bottom: 15px; }
        .box { border: 1px solid #ccc; padding: 8px 10px; margin-bottom: 12px; }
        .box strong { display: inline-block; width: 80px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #f0f0f0; text-align: left; padding: 6px; border: 1px solid #ccc; }
        td { padding: 6px; border: 1px solid #ccc; }
        .right { text-align: right; }
        .total td { font-weight: bold; background: #f7f7f7; }
        .footer { margin-top: 25px; font-size: 9px; color: #888; text-align: center; border-top: 1px solid #ddd; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>NOTA FISCAL (SIMULADA) &mdash; Pedido #{{ $order->id }}</h1>
        <div class="muted">
            Status: {{ $order->status->label() }} &nbsp;|&nbsp;
            Emitido em: {{ ($order->billed_at ?? $order->created_at)->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="box">
        <div><strong>Cliente:</strong> {{ $order->client->name }}</div>
        <div><strong>Documento:</strong> {{ $order->client->document_formatted }}</div>
        @if ($order->client->address)
            <div><strong>Endereço:</strong> {{ $order->client->address }}</div>
        @endif
        @if ($order->client->email)
            <div><strong>E-mail:</strong> {{ $order->client->email }}</div>
        @endif
        <div><strong>Vendedor:</strong> {{ $order->user->name }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th class="right">Preço unit.</th>
                <th class="right">Qtd.</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="right">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3" class="right">TOTAL</td>
                <td class="right">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @if ($order->notes)
        <div class="box" style="margin-top: 12px;">
            <strong>Obs.:</strong> {{ $order->notes }}
        </div>
    @endif

    <div class="footer">
        Documento gerado para fins acadêmicos, sem valor fiscal.
    </div>
</body>
</html>
