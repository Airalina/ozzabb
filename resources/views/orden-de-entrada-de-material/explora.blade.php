<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Detalle de orden de entrada: {{$entry_order_id}}</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th style="text-align: center">Código Material</th>
                      <th style="text-align: center">Descripción</th>
                      <th style="text-aling: center">N° Deposito</th>
                      <th style="text-align: center">Presentación</th>
                      <th style="text-align: center">Cantidad recibida</th>
                      <th style="text-align: center">Cantidad requerida</th>
                      <th style="text-align: center">Cantidad remito</th>
                      <th style="text-align: center">Diferencia</th>
                      <th style="text-align: center">Sin Entrgar</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($orderdetails as $order)
                    <tr>
                      <td style="text-align: center">{{ $order->material_code}}</td>
                      <td style="text-align: center">{{ $order->material_description }}</td>
                      <td style="text-align: center">{{ $order->warehouse_id }}</td>
                      <td style="text-align: center">{{ $order->presentation}}</td>
                      <td style="text-align: center">{{ $order->amount_received}}</td>
                      <td style="text-align: center">{{ $order->amount_requested}}</td>
                      <td style="text-align: center">{{ $order->amount_follow}}</td>
                      <td style="text-align: center">{{ $order->difference}}</td>
                      <td style="text-align: center">{{ $order->amount_undelivered}}</td>
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