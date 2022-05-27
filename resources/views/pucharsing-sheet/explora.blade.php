<div>
    <button wire:click="backlist()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div><br>
<div>
    <div class="card card-tabs">       
        <div class="card-body table-responsive">
            <form>
                <div class="card-header">
                    <h3 class="card-title">Pedidos de clientes en planilla de compra:</h3>
                    <br>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Nombre del cliente</th>
                                <th style="text-align: center">Fecha estimada de entrega</th>
                                <th style="text-align: center">Estado</th>
                                <th style="text-align: center">Fecha de pedido</th>
                                <th style="text-align: center">Tiene compras</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ordenes as $orden)
                            <tr>
                                <td style="text-align: center">{{ $orden['id'] }}/{{ date('Y', strtotime($orden['date']))}}
                                 </td>
                                <td style="text-align: center">{{ $orden['customer_name'] }}</td>
                                <td style="text-align: center">{{ date('d/m/Y', strtotime($orden['date']))}}</td>
                                @switch($orden['order_state'])
                                @case(1)
                                <td style="text-align: center">Nuevo</td>
                                @break
                                @case(2)
                                <td style="text-align: center">Confirmado</td>
                                @break
                                @case(3)
                                <td style="text-align: center">Rechazado</td>
                                @break
                                @case(4)
                                <td style="text-align: center">Demorado</td>
                                @break
                                @case(5)
                                <td style="text-align: center">En producción</td>
                                @break
                                @case(6)
                                <td style="text-align: center">En depósito</td>
                                @break
                                @case(7)
                                <td style="text-align: center">Cancelado</td>
                                @break
                                @endswitch
                                <td style="text-align: center">{{ date('d/m/Y', strtotime($orden['date']))}}</td>
                                @switch($orden['buys'])
                                @case(null)
                                <td style="text-align: center">No</td>
                                @break
                                @case(1)
                                <td style="text-align: center">No</td>
                                @break
                                @case(2)
                                <td style="text-align: center">Si</td>
                                @break
                                @endswitch
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


        <div class="card-body table-responsive">
            <form>
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Descripción</th>
                                    <th style="text-align: center">Stock</th>
                                    <th style="text-align: center">Stock en tránsito</th>
                                    <th style="text-align: center">Proveedor</th>
                                    <th style="text-align: center">Packaging</th>
                                    <th style="text-align: center">Cantidad</th>
                                    <th style="text-align: center">Cantidad total</th>
                                    <th style="text-align: center">P/U U$D</th>
                                    <th style="text-align: center">Subtotal U$D</th>
                  
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pucharsing_sheets_materials as $purchasing)
                                    <tr>
                                        <td style="text-align: center">{{ $purchasing[0]->code }}</td>
                                        <td style="text-align: center">{{ $purchasing[0]->description }}</td>
                                        <td style="text-align: center">{{ $purchasing[0]->stock }}</td>
                                        <td style="text-align: center">{{ $purchasing[0]->stock_transit }}</td>
                                        <td style="text-align: center">{{ $purchasing[1]->name }}</td>
                                        <td style="text-align: center">{{ $purchasing[2] }}</td>
                                        <td style="text-align: center">{{ $purchasing[3] }}</td>
                                        <td style="text-align: center">{{ $purchasing[2]*$purchasing[3]  }}</td>
                                        <td style="text-align: center">{{ $purchasing[4] }}</td>
                                        <td style="text-align: center">{{ $purchasing[5] }}</td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="100%" class="py-3 italic">No hay ordenes agregadas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                <label>Subtotal</label>
                <p>{{ $subtotal }}</p>
                <label>IVA(%)</label>
                <input class="form-control form-control-sm" type="number" wire:model="iva" 
                    placeholder="IVA" style="width: 60px;" disabled>
                <label>Precio total</label>

                <p>{{$total_price}}</p>

            </form>
        </div>
    </div>
  

</div>