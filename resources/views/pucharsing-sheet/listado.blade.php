<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Planillas de compra Registradas</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="searchP" type="text" class="form-control float-right"
                                placeholder="Buscar Planilla...">
                        </div>
                    </div>
        </div>
        <div class="card-header">
            <div>
                <label class="float-left">Registros por página:</label><input style="width: 60px; height: 30px"
                    type="number" min="1" wire:model="paginas" class="form-control">
            </div>
            <div class="card-tools">
                @if (auth()->user()->can('storeprovider', auth()->user()))
                <div class="input-group input-group-sm" style="width: 150px;">
                    <button wire:click="funcion()" type="button" class="btn btn-info btn-sm">Agregar Planilla 
                        </button>
                </div>
                @endif
            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-head  table-sm">
                <div class="form-group" data-select2-id="45">
                    <label>Ordenar por</label>
                    <select wire:model="order_list" class="form-control select2bs4 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="47" value="id">ID</option>
                        <option data-select2-id="48" value="date">Fecha</option>
                        <option data-select2-id="49" value="usd_total_price">Costo total</option>
                    </select>
                </div>
                <thead>
                    <tr>
                        <th style="text-align: center">ID</th>
                        <th style="text-align: center">Fecha</th>
                        <th style="text-align: center">Cantidad de órdenes</th>
                        <th style="text-align: center">Costo total</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($purchasing_sheets as $purchasing_sheet)
                    <tr class="registros">
                        <td style="text-align: center">{{ $purchasing_sheet->id }}</td>
                        <td style="text-align: center">{{ date('d-m-Y', strtotime($purchasing_sheet->date)) }}</td>
                        <td style="text-align: center">{{ count($purchasing_sheet->buyorders) }}</td>
                        @if(!empty($purchasing_sheet->usd_total_price))
                        <td style="text-align: center">${{ $purchasing_sheet->usd_total_price }}</td>
                        @else
                        <td style="text-align: center"></td>
                        @endif
                        <td style="text-align: center">
                            <button type="button" wire:click="explora({{ $purchasing_sheet->id }})" class="btn btn-primary btn-sm"><i
                                class="fas fa-file-alt"></i> Ver</button>
                       
                            <button type="button" wire:click="buy_orders({{ $purchasing_sheet->id }})" class="btn btn-primary btn-sm"><i
                                class="fas fa-file-alt"></i> Ordenes de compra</button>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="4" class="py-3 italic">No hay información</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $purchasing_sheets->links() }}
        </div>
        <!-- /.card-body -->
    </div>
</div>