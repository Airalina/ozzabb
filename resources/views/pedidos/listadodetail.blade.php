<div class="card-tools">
              <div>
                    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    	        </div>
              <br>
          <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> SETECEL S.R.L
                    @if($order->order_state==1)
                    <small class="float-right"><button wire:click="deleteorder({{ $order->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button></small>
                    @endif 
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  De:
                  <address>
                    <strong>Setece S.R.L.</strong><br>
                    Direccion Setecel<br>
                    San Juan, San Juan<br>
                    Argentina<br>
                    CP:5400<br>
                    Telefono: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Para:
                  <address>
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $address->street }}, {{ $address->number }} <br>
                    {{ $address->location }}, {{ $address->province }}<br>
                    {{ $address->country }}<br>
                    CO: {{ $address->postcode }}<br>
                    Telefono: {{ $customer->phone }}<br>
                    Email: {{ $customer->email }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Detalles de pedido:
                  <br>
                  <b>Pedido #:</b> {{ $order->id }}/2021<br>
                  <b>Fecha y hora de pedido :</b> {{ date('d-m-Y', strtotime($order->date)) }}<br>
                  <b>Fecha estimada de entrega :</b> {{ date('d-m-Y', strtotime($order->deadline)) }}<br>
                  <b>Orden de trabajo:</b>{{ $order->order_job }}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th style="text-align: center">Cantidad</th>
                      <th style="text-align: center">Codigo de producto #</th>
                      <th style="text-align: center">Precio Unitario U$D</th>
                      <th style="text-align: center">Subtotal</th>
                      @if($order->order_state==1)
                      <th style="text-aling: center"><button wire:click="addinstallationtoorder({{ $order->id }})" type="button" class="btn btn-success btn-sm">Agregar Producto</button></th>
                      @else
                      <th></th>
                      @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($details as $det)
                      <tr>
                        <td style="text-align: center">{{$det->cantidad}}</td>
                        <td style="text-align: center">{{$det->material_id}}</td>
                        <td style="text-align: center">{{$det->unit_price_usd}}</td>
                        <td style="text-align: center">{{$det->unit_price_usd*$det->cantidad}}</td>
                        <td></td>
                      </tr>
                    @empty
                        <tr class="text-center">
                            <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                        </tr>
                    @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Monto adeudado:</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Total U$D:</th>
                        <td>{{ $order->usd_price}}</td>
                      </tr>
                      <tr>
                        <th>Total AR$:</th>
                        <td>{{ $order->arp_price}}</td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Imprimir</a>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generar PDF
                  </button>
                </div>
              </div>
            </div>
          
</div>