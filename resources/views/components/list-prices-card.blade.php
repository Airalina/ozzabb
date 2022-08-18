<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de precios del {{ $type }}</h3>
        <div class="card-tools">
            @if (auth()->user()->can($permission, auth()->user()))
                <div>
                    <button wire:click="createPrice()" type="button" class="btn btn-info btn-sm">Agregar
                        Precio</button>
                </div>
            @endif
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>{{ $type == 'material' ? 'Proveedor' : 'Material' }}</th>
                    <th>Packaging</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Precio U$D</th>
                    <th>Precio AR$</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($providerPrices as $providerPrice)
                    <tr>
                        <td>{{ $providerPrice->provider_code }}</td>
                        <td>{{ $providerPrice->provider->name }}</td>
                        <td>{{ $providerPrice->unit }} {{ $providerPrice->presentation }}</td>
                        <td>{{ $providerPrice->amount }}</td>
                        <td>{{ $providerPrice->created_at->format('d/m/Y') }}</td>
                        <td>{{ $providerPrice->usd_price }}</td>
                        <td>{{ $providerPrice->ars_price }}</td>
                        @if (auth()->user()->can($permission, auth()->user()))
                            <td><button
                                    wire:click="editPrice({{ $providerPrice->material_id }},{{ $providerPrice->id }})"
                                    type="button" class="btn btn-success btn-sm">Actualizar</button></td>
                        @endif
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4" class="py-3 italic">No hay información</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
