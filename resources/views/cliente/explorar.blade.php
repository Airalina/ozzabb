<div class="card-tools">
              <div>
                    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    	        </div>
              <br>
              <div class="card-header">
                <h6 class="card-title">Usted a seleccionado el cliente con codigo: {{ $cliente->id }} </h6>
                @if (auth()->user()->can('storepedidos', auth()->user()))
                <div class="card-tools">
                  <button wire:click="goOrder({{ $cliente->id }})" type="button" class="btn btn-info">Nuevo Pedido</button>
                </div>
                @endif
</div>
<div class="row">
    <table class="table table-hover table-sm">
          <thead>        
            
                    <tr>
                      <th>Nombre</th>
                      <th>Telefono</th>
                      <th>Email</th>
                      <th>Domicilio Administrativo</th>
                      <th>Contacto</th>
                      <th>Cargo del contacto</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    <td>{{ $cliente->name }}</td>
                      <td>{{ $cliente->phone }}</td>
                      <td>{{ $cliente->email}}</td>
                      <td>{{ $cliente->domicile_admin}}</td>
                      <td>{{ $cliente->contact}}</td>
                      <td>{{ $cliente->post_contact}}</td>
                      @if($cliente->estado)
                        <td>Activo</td>
                      @else
                        <td>Inactivo</td>
                      @endif
                    </tr>
                  </tbody>
    </table>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Direcciones de entrega del cliente</h3>
                <div class="card-tools">
                  @if (auth()->user()->can('storecust', auth()->user()))  
                    <div>
                      <button wire:click="agregadom()" type="button" class="btn btn-info">Agregar Direccion</button>
    	              </div>
                  @endif
                </div>
            </div>
              <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Calle</th>
                      <th>Numero</th>
                      <th>Localidad</th>
                      <th>Provincia</th>
                      <th>Pais</th>
                      <th>Codigo Postal</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse($domicilios as $domicilio)
                        <tr>
                            <td>{{$domicilio->street}}</td>
                            <td>{{$domicilio->number}}</td>
                            <td>{{$domicilio->location}}</td>
                            <td>{{$domicilio->province}}</td>
                            <td>{{$domicilio->country}}</td>
                            <td>{{$domicilio->postcode}}</td>
                            @if (auth()->user()->can('deletecust', auth()->user()))
                            <td><button wire:click="destruirdir({{ $domicilio->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button></td>
                            @endif
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4" class="py-3 italic">No hay información</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Ultimos 10 pedidos del cliente</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Nro. de Pedido</th>
                      <th>Fecha de Pedido </th>
                      <th>Fecha de Entrega</th>
                      <th>Fecha de Inicio</th>
                      <th>Estado</th>
                      <th>Precio Total U$D</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse($historial as $historia)
                <tr class="registros">
                      <td style="text-align: center">{{ $historia->id }}/{{Carbon\Carbon::parse($historia->date)->format('Y')}}</td>
                      <td style="text-align: center">{{ Carbon\Carbon::parse($historia->date)->format('d/m/Y') }}</td>
                      <td style="text-align: center">{{ $historia->deadline->format('d/m/Y') }}</td>
                      <td style="text-aling: center">{{ Carbon\Carbon::parse($historia->start_date)->format('d/m/Y') }}</td>
                      @if($historia->order_state==1)
                        <td style="text-align: center">Nuevo</td>
                      @elseif($historia->order_state==2)
                        <td style="text-align: center">Confirmado</td>
                      @elseif($historia->order_state==3)
                        <td style="text-align: center">Rechazado</td> 
                      @elseif($historia->order_state==4)
                        <td style="text-align: center">Demorado</td>
                      @elseif($historia->order_state==5)
                        <td style="text-align: center">En Producción</td>
                      @elseif($historia->order_state==6)
                        <td style="text-align: center"> En Depósito</td> 
                      @endif
                      <td style="text-align: center">{{ $historia->usd_price }} U$D</td>
                      <td style="text-align: center"><button wire:click="orderdetail({{ $historia->id }})" type="button" class="btn btn-primary btn-sm">Ver detalle</button></td>
                </tr>
              @empty
                <tr class="text-center">
                  <td colspan="4" class="py-3 italic">No hay información</td>
                </tr>
              @endforelse 
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          @include('borrar')
</div>