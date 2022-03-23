<div>
    <button wire:click="backlist()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div><br>
<div>
    <div class="card card-tabs">                    
        <div class="card-body table-responsive">
            <form>
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Número de orden</th>
                                    <th style="text-align: center">Proveedor</th>
                                    <th style="text-align: center">Fecha de orden</th>
                                    <th style="text-align: center">Cantidad de materiales pedidos</th>
                                    <th style="text-align: center">Total U$D</th>
                                    <th style="text-align: center">Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buy_orders as $order)
                                    <tr>
                                        <td style="text-align: center">{{ $order->order_number }}</td>
                                        <td style="text-align: center">{{ $order->provider->name }}</td>
                                        <td style="text-align: center">{{ date('d-m-Y H:i', strtotime($order->buy_date))  }}</td>
                                        <td style="text-align: center">{{ count($order->buyorderdetails) }}</td>
                                        <td style="text-align: center">{{ $order->total_price }}</td>
                                        @if($order->state==1)
                                            <td style="text-align: center">Mail enviado</td>
                                        @else
                                            <td style="text-align: center">Mail no enviado</td>
                                        @endif
                                        <td style="text-align: center">
                                            <button type="button" wire:click="exploraorder({{ $order->id }})" class="btn btn-primary btn-sm"><i
                                            class="fas fa-file-alt"></i>Ver</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="100%" class="py-3 italic">No hay ordenes agregadas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                </div>
            </form>
        </div>
    </div>
</div>