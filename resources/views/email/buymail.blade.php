<div class="card-tools">
          <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> SETECEL S.R.L 
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
                </div><b><b>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Para:
                  <address>
                    <strong>{{ $ordenes->provider->name }}</strong><br>
                    Dirección: {{ $ordenes->provider->address }}<br>
                    Telefono: {{ $ordenes->provider->phone }}<br>
                    Email: {{ $ordenes->provider->email }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Detalles de pedido:
                  <br>
                  <b>Pedido #:</b> {{ $ordenes->order_number }}<br>
                  <b>Fecha y hora de pedido :</b> {{ date('d-m-Y H:i', strtotime($ordenes->created_at)) }}<br>
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
                      <th style="text-align: center">Codigo de material</th>
                      <th style="text-align: center">Packaging</th>
                      <th style="text-align: center">Precio Unitario U$D</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($ordenes->buyorderdetails as $det)
                      <tr>
                        <td style="text-align: center">{{$det->amount}}</td>
                        <td style="text-align: center">{{$det->materials->code}}</td>
                        <td style="text-align: center">{{$det->presentation}}</td>
                        <td style="text-align: center">{{$det->presentation_price}}</td>
                        <td></td>
                      </tr>
                    @empty
                        <tr class="text-center">
                            <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                        </tr>
                    @endforelse
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td style="text-align: center">Total</td>
                      <td style="text-align: center">{{$det->buyorders->total_price}}</td>
                    </tr>
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
                        <td>{{ $det->buyorders->total_price}}</td>
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