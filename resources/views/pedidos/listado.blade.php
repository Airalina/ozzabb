<div>
<div class="card">
            <div class="card-header">
                <h3 class="card-title">Pedidos Registrados</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input wire:model="search" type="text" class="form-control float-right" placeholder="Buscar Pedido...">
                    </div>
                </div>
                
            </div>
            <div class="card-header">
            <div>  
                  <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" min="1" wire:model="paginas" class="form-control">
            </div>
            <div class="card-tools">
                  @if (auth()->user()->can('storepedidos', auth()->user()))
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <button wire:click="funcion()" type="button" class="btn btn-info btn-sm">Agregar Pedido</button>
                    </div>
                  @endif
                </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table class="table table-head  table-sm">
                  <thead>
                    <tr>
                      <th style="text-align: center">Pedido #</th>
                      <th style="text-align: center">Codigo de Cliente</th>
                      <th style="text-align: center">Cliente</th>
                      <th style="text-align: center">Fecha de Entrega</th>
                      <th style="text-align: center">Estado</th>
                      <th style="text-align: center">Deposito</th>
                      <th style="text-align: center">Fecha de Inicio</th>
                      <th style="text-align: center">Orden de Trabajo</th>
                      <th style="text-align: center">Total U$D</th>
                      <th style="text-align: center">Total AR$</th>
                      <th></th>
                    </tr>
                  </thead>
                  
            <tbody>
              @forelse($orders as $order)
                <tr class="registros">
                      <td style="text-align: center">{{ $order->id }}/{{$order->deadline->format('Y')}}</td>
                      <td style="text-align: center">{{ $order->customer_id }}</td>
                      <td style="text-align: center">{{ $order->customer_name}}</td>
                      <td style="text-align: center">{{ $order->deadline->format('d/m/Y') }}</td>
                      @if($order->order_state==1)
                        <td style="text-align: center">Nuevo</td>
                      @elseif($order->order_state==2)
                        <td style="text-align: center">Confirmado</td>
                      @elseif($order->order_state==3)
                        <td style="text-align: center">Rechazado</td> 
                      @elseif($order->order_state==4)
                        <td style="text-align: center">Demorado</td>
                      @elseif($order->order_state==5)
                        <td style="text-align: center">En Producción</td>
                      @elseif($order->order_state==6)
                        <td style="text-align: center"> En Depósito</td> 
                      @endif
                      <td style="text-align: center"> - </td>
                      <td style="text-align: center"> - </td>
                      <td style="text-align: center"> - </td>
                      <td style="text-align: center">{{ $order->usd_price }} U$D</td>
                      <td style="text-align: center">{{ $order->arp_price }} AR$</td>


                      <td >
                      <button type="button" wire:click="explora({{ $order->id }})" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i>    Ver</button>
                      @if($order->order_state==1)
                        @if (auth()->user()->can('updatepedidos', auth()->user()))
                          <button type="button" wire:click="update({{ $order->id }})" class="btn btn-success btn-sm"> Actualizar</button>
                        @endif
                        @if (auth()->user()->can('deletepedidos', auth()->user()))
                        <button wire:click="destruir({{ $order->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button>
                        @endif
                      @endif
                      </td>      
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="4" class="py-3 italic">No hay información</td>
                </tr>
              @endforelse 
            </tbody>
                </table>
                {{ $orders->links() }}
              </div>
              <!-- /.card-body -->
            </div>
            @include('borrar')
</div>
