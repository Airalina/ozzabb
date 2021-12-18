<div>
    <button wire:click="backlist()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div><br>
<div>
    <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title">Planilla de compra</h3>
            <div class="card-tools">
                @if (auth()->user()->can('storeprovider', auth()->user()))
                    <div>
                        <button wire:click="funcion()" type="button" class="btn btn-info">Realizar pedido</button>
                    </div>
                @endif
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input wire:model="searchP" type="text" class="form-control float-right"
                        placeholder="Buscar planilla de compra">
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-head table-sm">
                <thead>
                    <tr>
                    <th>Código material</th>
                        <th>Descripción material</th>
                        <th>Proveedor</th>
                        <th>Presentación</th>
                        <th>P/U U$D</th>
                        <th>Cantidad</th>
                        <th>Total U$D</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($purchasings as $purchasing)
                        <tr class="registros">
                            <td>{{ $purchasing->materials->code }}</td>
                            <td>{{ $purchasing->materials->description }}</td>
                            <td>{{ $purchasing->providers->name }}</td>
                            <td>{{ $purchasing->presentation }}</td>
                            <td>{{ $purchasing->usd_price }}</td>
                            <td>{{ $purchasing->amount }}</td>
                            <td>{{ $purchasing->usd_price*$purchasing->amount }}</td>
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
</div>
