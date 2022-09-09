<thead>
    <tr>
        <th style="text-align: center">Id ensamblado</th>
        <th style="text-align: center">Descripción</th>
        <th style="text-align: center">Cantidad</th>
        <th></th>
    </tr>
</thead>
<tbody> 
    @forelse($elements as $element)
        <tr>
            <td style="text-align: center">{{ $element['id'] }}</td>
            <td style="text-align: center">{{ $element['description'] }}</td>
            <td style="text-align: center">{{ $element['amount'] }}</td>
        </tr>
    @empty
        <tr class="text-center">
            <td colspan="100%" class="py-3 italic">No hay información</td>
        </tr>
    @endforelse
</tbody>