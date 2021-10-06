<div>
    <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title">Planillas de compra</h3>
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
            <table class="table table-head text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($purchasing_sheets as $purchasing_sheet)
                        <tr class="registros">
                            <td>{{ $purchasing_sheet->id }}</td>
                            <td>{{ $purchasing_sheet->date }}</td>
                            <td>
                               
                            </td>
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
