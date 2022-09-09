<thead>
    <tr>
        <th style="text-align: center">ID</th>
        <th style="text-align: center">Código</th>
        <th style="text-align: center">Descripción</th>
        <th style="text-align: center">Packaging</th>
        <th style="text-align: center">Cantidad</th>
        <th style="text-align: center">Total</th>
        <th></th>
    </tr>
</thead>
<tbody> 
    @forelse($elements as $element)
        <tr>
            <td style="text-align: center">{{ $element['id'] }}</td>
            <td style="text-align: center">{{ $element['code'] }}</td>
            <td style="text-align: center">{{ $element['description'] }}</td>
            <td style="text-align: center">
                <x-show-list-elements :items="$element['packaging']" />
            </td>
            <td style="text-align: center">
                <x-show-list-elements :items="$element['amount']" />
            </td>
            <td style="text-align: center">
                <x-show-list-elements :items="$element['total']" />
            </td>
        </tr>
    @empty
        <tr class="text-center">
            <td colspan="100%" class="py-3 italic">No hay información</td>
        </tr>
    @endforelse
</tbody>