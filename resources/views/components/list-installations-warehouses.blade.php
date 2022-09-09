<thead>
    <tr>
        <th style="text-align: center">N° de version</th>
        <th style="text-align: center">N° de serie</th>
        <th style="text-align: center">Código</th>
        <th style="text-align: center">Descripción</th>
        <th style="text-align: center">N° de pedido</th>
        <th style="text-align: center">Cantidad</th>
    </tr>
</thead>
<tbody>
    @forelse($elements as $elemet)
        <tr>
            <td style="text-align: center">{{ $elemet['number_version'] }}</td>
            <td style="text-align: center">{{ $elemet['serial_number'] }}</td>
            <td style="text-align: center">{{ $elemet['code'] }}</td>
            <td style="text-align: center">{{ $elemet['description'] }}</td>
            <td style="text-align: center">{{ $elemet['client_order_id'] }}</td>
            <td style="text-align: center">{{ $elemet['amount'] }}</td>
        </tr>
    @empty
        <tr class="text-center">
            <td colspan="4" class="py-3 italic">No hay información</td>
        </tr>
    @endforelse
</tbody>
