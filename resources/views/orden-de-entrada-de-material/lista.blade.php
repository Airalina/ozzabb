<div>
    <div class="card">
        <style>
            nav svg {
                height: 20px;
            }

        </style>
        <div class="card-header">
            <h3 class="card-title">Ordenes de ingreso de materiales</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input wire:model="searchordenesem" type="text" class="form-control float-right"
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
                <thead>
                    <tr>
                        <th style="text-align: center">Orden de ingreso #</th>
                        <th style="text-align: center">Orden de compra #</th>
                        <th style="text-align: center">N° de remito</th>
                        <th style="text-align: center">Proveedor </th>
                        <th style="text-align: center">Origen </th>
                        <th style="text-align: center">Causa </th>
                        <th style="text-align: center">Cantidad materiales</th>
                        <th style="text-align: center">Fecha y hora</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td style="text-align: center">{{ $order->id }}</td>
                            <td style="text-align: center">{{ $order->buy_order_id }}</td>
                            <td style="text-align: center">{{ $order->follow_number }}</td>
                            <td style="text-align: center">
                                @if(!is_null($order->buy_order_id))
                                      {{ $order->buy_order->provider->name }}
                                @else
                                    &nbsp
                                @endif
                              
                            </td>
                            <td style="text-align: center">{{ $order->origin }}</td>
                            <td style="text-align: center">{{ $order->reason }}</td>
                            <td style="text-align: center">{{ $order->materialentryorderdetails->count() }}</td>
                            <td style="text-align: center">{{ date('d-m-Y', strtotime($order->date)) }}
                                {{ $order->hour }}</td>
                            <td style="text-align: center">
                                <button type="button" wire:click="explora({{ $order->id }})"
                                    class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                                 
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>

</div>
