<div>
    <div class="card">
        <style>
            nav svg {
                height: 20px;
            }

        </style>
        <div class="card-header">
            <h3 class="card-title">Órdenes de egreso de materiales</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input wire:model="search" type="text" class="form-control float-right"
                        placeholder="Buscar Orden...">
                </div>
            </div>

        </div>
        <div class="card-header">
            <div>
                <label class="float-left">Registros por página:</label><input style="width: 60px; height: 30px"
                    type="number" min="1" wire:model="paginas" class="form-control">
            </div>
            <div class="card-tools">
                @if (auth()->user()->can('storepedidos', auth()->user()))
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Nueva Orden</button>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-head  table-sm">
                <div class="form-group" data-select2-id="45">
                    <label>Ordenar por</label>
                    <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="47" value="code">N° de orden</option>
                        <option data-select2-id="49" value="date">Fecha</option>
                        <option data-select2-id="49" value="hour">Hora</option>
                        <option data-select2-id="48" value="responsible">Usuario que retira</option>
                        <option data-select2-id="49" value="destination">Destino</option>
                        <option data-select2-id="49" value="products">Cantidad de productos</option>
                        <option data-select2-id="49" value="units">Cantidad de unidades</option>
                        <option data-select2-id="49" value="status">Estado</option>
                    </select>
                </div>
                <thead>
                    <tr>
                        <th style="text-align: center">N° de orden</th>
                        <th style="text-align: center">Fecha y hora</th>
                        <th style="text-align: center">Usuario que retira</th>
                        <th style="text-align: center">Destino</th>
                        <th style="text-align: center">Cantidad de productos </th>
                        <th style="text-align: center">Cantidad de unidades </th>
                        <th style="text-align: center">Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td style="text-align: center">{{ $order->code }}</td>
                        <td style="text-align: center">{{ date('d-m-Y', strtotime($order->date)) }} {{ $order->hour }}</td>
                        <td style="text-align: center">{{ $order->responsible }}</td>
                        <td style="text-align: center">{{ $order->destination }}</td>
                        <td style="text-align: center">{{ $order->products }}</td>
                        <td style="text-align: center">{{ $order->units }}</td>
                        <td style="text-align: center">{{ ($order->status == 1) ? 'Realizada' : 'Cancelada' }}</td>
                        <td style="text-align: center">
                            <button type="button" wire:click="explora({{ $order->id }})"
                                class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> ver</button>
                            @if ($order->status != 0)
                                <button type="button" wire:click="cancelar({{ $order->id }})"
                                class="btn btn-danger btn-sm"><i class="fas fa-ban"></i> Cancelar</button>
                             
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
         
        </div>
    </div>

</div>
