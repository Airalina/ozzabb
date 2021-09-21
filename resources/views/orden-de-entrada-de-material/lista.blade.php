            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Ordenes</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  <div>
                    <input type="text" name="searchordenesem" wire:model="searchdeposito" class="form-control float-right" placeholder="Buscar">
                  </div>
                  </div>
                </div>
                 </div>
              <div class="card-header">
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div>
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Nueva Orden</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th style="text-align: center">N° Orden de entrada</th>
                      <th style="text-align: center">N° Orden de compra</th>
                      <th style="text-aling: center">N° de remito</th>
                      <th style="text-align: center">Proveedor</th>
                      <th style="text-align: center">Cantidad de materiales</th>
                      <th style="text-align: center">Fecha y hora</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($orders as $order)
                    <tr>
                      <td style="text-align: center">{{ $order->id }}</td>
                      <td style="text-align: center">{{ $order->buy_order_id }}</td>
                      <td style="text-align: center">{{ $order->follow_number }}</td>
                      <td style="text-align: center">aqui proveedor-relacionado a orden de compra.</td>
                      <td style="text-align: center">{{ $order->materialentryorderdetails->count()}}</td>
                      <td style="text-align: center">{{ date('d-m-Y', strtotime($order->date)) }} {{ $order->hour }}</td>
                      <td style="text-align: center">
                        <button type="button" wire:click="explora({{$order->id}})" class="btn btn-primary btn-xs"><i class="fas fa-file-alt"></i> Ver</button>
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
              <!-- /.card-body -->
            </div>