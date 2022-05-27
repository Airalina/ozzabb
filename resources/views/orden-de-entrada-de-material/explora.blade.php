<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalle de orden de ingreso: {{ $entry_order_id }}</h3>
    </div>
    <div class="card-body">
        @if (!empty($entry_order_type))
            <label>Tipo de orden de ingreso: Sin orden de compra</label>
            <div class="form-group">
                <label>Origen</label>
                <input class="form-control form-control-sm" type="text" wire:model="origen" style="width: 300px;"
                    placeholder="Ingrese origen del material a ser ingresado" readonly>
            </div>
            <div class="form-group">
                <label>Causa</label>
                <input class="form-control form-control-sm" type="text" wire:model="causa" style="width: 300px;"
                    placeholder="Ingrese causa por la cual ingresa los materiales" readonly>
            </div>
        @else
            <label>Tipo de orden de ingreso: Con orden de compra</label>
            <div class="form-group">
                <label>N° de remito:</label>
                <input class="form-control form-control-sm" type="text" wire:model="follow" style="width: 300px;"
                    placeholder="Ingrese N° remito" readonly>
            </div>
        @endif
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" wire:model="date" class="form-control form-control-sm" style="width: auto"
                placeholder="dd/mm/AAAA" readonly>
        </div>
        <div class="form-group">
            <label>Hora</label>
            <input type="time" wire:model="hour" class="form-control form-control-sm" style="width: auto"
                placeholder="" readonly>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Materiales agregados</h3>
                    <br>

                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center">Código Material</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-aling: center">N° Deposito</th>
                                <th style="text-align: center">Packaging</th>
                                <th style="text-align: center">Cantidad enviada</th>
                                @if (empty($entry_order_type))
                                    <th style="text-align: center">Cantidad pedida</th>
                                    <th style="text-align: center">Cantidad remito</th>
                                    <th style="text-align: center">Diferencia</th>
                                    <th style="text-align: center">Sin Entregar</th>
                                @endif
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orderdetails as $order)
                                <tr>
                                    <td style="text-align: center">{{ $order->material_code }}</td>
                                    <td style="text-align: center">{{ $order->material_description }}</td>
                                    @if($order->warehouse)
                                        <td style="text-align: center">{{ $order->warehouse->name }}</td>
                                    @else
                                        <td style="text-align: center">Entrada sin deposito</td>
                                    @endif
                                    <td style="text-align: center">{{ $order->presentation }}</td>
                                    <td style="text-align: center">{{ $order->amount_received }}</td>
                                    @if (empty($entry_order_type))
                                        <td style="text-align: center">{{ $order->amount_requested }}</td>
                                        <td style="text-align: center">{{ $order->amount_follow }}</td>
                                        <td style="text-align: center">{{ $order->difference }}</td>
                                        <td style="text-align: center">{{ $order->amount_undelivered }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td style="text-align: center" colspan="4" class="py-3 italic">No hay información
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="col">

        </div>
    </div>
    <!-- /.card-body -->
</div>
