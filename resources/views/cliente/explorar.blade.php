<div class="card-tools">
              <div>
                    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    	        </div>
              <br>
              <div class="card-header">
                <h6 class="card-title">Usted a seleccionado el cliente con codigo: {{ $cliente->id }} </h6>

                <div class="card-tools">
                  <button wire:click="goOrder({{ $cliente->id }})" type="button" class="btn btn-info">Nuevo Pedido</button>
                </div>
</div>
<div class="row">
    <table class="table table-hover text-nowrap">
          <thead>        
            
                    <tr>
                      <th>Nombre</th>
                      <th>Telefono</th>
                      <th>Email</th>
                      <th>Domicilio Administrativo</th>
                      <th>Contacto</th>
                      <th>Cargo del contacto</th>
                      <th>Estado</th>
                      <th><th>
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
                      @if($cliente==true)
                        <td>Activo</td>
                      @else
                        <td>Inactivo</td>
                      @endif
                      <td>
                        @if (auth()->user()->can('updatecust', auth()->user()))
                          <button wire:click="update({{ $cliente->id }})" type="button"  class="btn btn-primary btn-sm">Actualizar</button>
                        @endif
                        @if (auth()->user()->can('deletecust', auth()->user())) 
                          <button wire:click="destruir({{ $cliente->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button>
                        @endif
                      <td>
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
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
</div>