<table class="table table-hover table-sm">
    <thead>
        <tr>
            <th style="text-align: center">Orden N°</th>
            <th style="text-align: center">Código</th>
            <th style="text-align: center">Descripción</th>
            <th style="text-align: center">Packaging</th>
            <th style="text-align: center">Cantidad {{ $type ? 'Ingresada' : 'Retirada' }}</th>
            <th style="text-align: center">Total</th>
            <th style="text-align: center"> {{ $type ? 'Origen' : 'Destino' }} </th>
            <th style="text-align: center">Tipo</th>
            <th style="text-align: center">Fecha</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($withdraws as $withdraw)
            <tr>
                <td style="text-align: center">{{ $withdraw['id'] }}</td>
                <td style="text-align: center">{{ $withdraw['code'] }}</td>
                <td style="text-align: center">{{ $withdraw['description'] }}</td>
                <td style="text-align: center">{{ $withdraw['packaging'] }}</td>
                <td style="text-align: center">{{ $withdraw['amount'] }}</td>
                <td style="text-align: center">{{ $withdraw['total'] }}</td>
                <td style="text-align: center">{{ $withdraw['warehouse_name'] }}</td>
                <td style="text-align: center">{{ $withdraw['warehouse_type'] }}</td>
                <td style="text-align: center">{{ $withdraw['date'] }}</td>
                @if ($detail)
                <td>
                    <button type="button" wire:click="retiroDetail({{ $withdraw['id'] }})"
                        class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                </td>
                @endif
            </tr>
        @empty
            <tr class="text-center">
                <td style="text-align: center" colspan="100%" class="py-3 italic">No hay información</td>
            </tr>
        @endforelse
    </tbody>
</table>
