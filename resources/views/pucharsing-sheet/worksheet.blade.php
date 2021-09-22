<div>
    <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title">Solicitud de pedidos</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <div class="form-group">
                <label>Fecha pedido</label>
                <div class="input-group input-group-sm">
                    <div>
                        <input wire:model="date" type="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Número de pedido</label>
                <div>
                    <input wire:model="search" type="text" class="form-control float-right" wire:keydown="backspace">
                </div>
            </div>
            @if ($select)
                <div>
                    <p class="card-title m-2">
                        Orden número: <b> {{ $order->id }}/{{ date('Y') }} </b> </p>
                </div>
            @elseif ($search != '')
                <table class="table table-head text-nowrap">
                    <thead>
                        <tr>
                            <th>Código pedido</th>
                            <th>Nombre del cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                            @forelse ($orders as $order)
                                <tr class="registros">
                                    <td>{{ $order->id }}/{{ date('Y') }} </td>
                                    <td>{{ $order->customer_name }} </td>
                                    <td><button type="button" wire:click="order_change({{ $order->id }})"
                                            class="btn btn-success btn-xs">Seleccionar</button></td>
                                </tr>
                            @empty
                                <tr> 
                                <td colspan="2" class="text-center">No hay registros </td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
            @endif
            @if ($div)
                <table class="table table-head text-nowrap">
                    <thead>
                        <tr>
                            <th>Código Pedido</th>
                            <th>Fecha entrega</th>
                            <th>Cantidad total</th>
                            <th>Estado</th>
                            <th>Compras</th>
                            <th>Fecha de inicio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="registros">
                            <td>{{ $order->id }} </td>
                            <td>{{ $order->deadline->format('d-m-Y') }}</td>
                            <td>{{ $total_amount }} </td>
                            <td>{{ $order->order_state }}</td>
                            <td>
                                @if (!empty($buys))
                                    No
                                @else
                                    Sí
                                @endif
                            </td>
                            <td> {{ $order->created_at->format('d-m-Y') }} </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <div class="form-group">
                    <button wire:click="save()" type="button" class="btn btn-primary">Guardar Cambios</button>
                </div> 
                -->
            @endif

        </div>
        <!-- /.card-body -->
    </div>
</div>
