<div>
<div class="card">
  <style>
    nav svg {
      height: 20px;
    }
  </style>
            <div class="card-header">
                <h3 class="card-title">Ordenes de Compra</h3>
                <br>
                <div>  
                      <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" min="1" wire:model="paginas1" class="form-control">
                </div>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  <div>
                    <input type="text" wire:model="searchorderbuy" class="form-control float-right" placeholder="Buscar">
                  </div>
                  </div>
                </div>
                 </div>
              <div class="card-body table-responsive p-0">
                <table class="table  table-hover  table-sm">
                  <thead>
                    <tr>
                      <th style="text-align: center">N° Orden de compra</th>
                      <th style="text-aling: center">Id de proveedor</th>
                      <th style="text-aling: center">Precio Total U$D</th>
                      <th style="text-align: center">Id planilla de compra</th>
                      <th style="text-align: center">Estado</th>
                      <th style="text-align: center">Fecha orden de compra</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($buyorders as $order)
                    <tr>
                      <td style="text-align: center">{{ $order->order_number }}</td>
                      <td style="text-align: center">{{ $order->provider_id }}</td>
                      <td style="text-align: center">{{ $order->total_price}}</td>
                      <td style="text-align: center">{{ $order->purchasing_sheet_id}}</td>
                      <td style="text-align: center">{{ $order->state}}</td>
                      <td style="text-align: center">{{ date('d-m-Y', strtotime($order->buy_date)) }}</td>
                      <td style="text-align: center">
                        <button type="button" wire:click="explorabuyorder({{$order->id}})" class="btn btn-success btn-sm"><i class="fas fa-file-alt"></i> Crear orden de ingreso</button>
                      </td>
                    </tr>
                    @empty
                      <tr class="text-center">
                        <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
                {{ $buyorders->links() }}
              </div>
          </div>
          <div class="card">
              <!-- /.card-body -->
              <div class="card-header">
                <h3 class="card-title">Ordenes de ingreso:</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  <div>
                    <input type="text" name="searchordenesem" wire:model="searchordenesem" class="form-control float-right" placeholder="Buscar">
                  </div>
                  </div>
                </div>
                 </div>
              <div class="card-header">
                <div>  
                      <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" min="1" wire:model="paginas" class="form-control">
                </div>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div>
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Nueva Orden</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive  p-0">
                <table class="table  table-hover  table-sm">
                  <thead>
                    <tr>
                      <th style="text-align: center">Orden de entrada</th>
                      <th style="text-align: center">Orden de compra</th>
                      <th style="text-align: center">N° de remito</th>
                      <th style="text-align: center">Proveedor Id </th>
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
                      @if($order->buyorders->where('id',$order->buy_order_id)==null)
                        {{s/n}}
                      @else
                      @foreach($order->buyorders->where('id',$order->buy_order_id) as $algo)
                        {{$algo->provider_id }} 
                      @endforeach
                      @endif
                      </td>
                      <td style="text-align: center">{{ $order->origin }}</td>
                      <td style="text-align: center">{{ $order->reason }}</td>
                      <td style="text-align: center">{{ $order->materialentryorderdetails->count()}}</td>
                      <td style="text-align: center">{{ date('d-m-Y', strtotime($order->date)) }} {{ $order->hour }}</td>
                      <td style="text-align: center">
                        <button type="button" wire:click="explora({{$order->id}})" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
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
              <!-- /.card-body -->
            </div>
  </div>