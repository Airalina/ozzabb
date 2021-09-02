<div class="card-body table-responsive p-0">
    
    <table class="table table-hover text-nowrap">
                  <thead>
                    
                    <div class="card-tools">
                    <div>
                      <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    	            </div>
                    <br>
                    <h6>    Usted a seleccionado el proveedor con codigo: {{ $provider->id }} </h6>
                </div>
                    <tr>
                      <th>Nombre</th>
                      <th>Domicilio</th>
                      <th>Teléfono</th>
                      <th>Correo electrónico</th>
                      <th>Nombre de contacto</th>
                      <th>Puesto de contacto</th>
                      <th>Página web</th>
                      <th>Estado</th>
                      <th><th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ $provider->name }} </td>
                      <td>{{ $provider->address }}  </td>
                      <td>{{ $provider->phone }} </td>
                      <td>{{ $provider->email }} </td>
                      <td>{{ $provider->contact_name }} </td>
                      <td>{{ $provider->point_contact }} </td>
                      <td>{{ $provider->site_url }} </td>
                      @if($provider->status==1)
                        <td>Activo</td>
                      @else
                        <td>Inactivo</td>
                      @endif
                      <td>
                        @if (auth()->user()->can('updateprovider', auth()->user()))
                          <button wire:click="update({{ $provider->id }})" type="button"  class="btn btn-primary btn-sm">Actualizar</button>
                        @endif
                        @if (auth()->user()->can('deleteprovider', auth()->user())) 
                          <button wire:click="destruir({{ $provider->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button>
                        @endif
                      <td>
                    </tr>
                  </tbody>
    </table>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de precios del proveedor</h3>
                <div class="card-tools">
                  @if (auth()->user()->can('storeprovider', auth()->user()))  
                    <div>
                      <button wire:click="agregamat({{ $provider->id }})" type="button" class="btn btn-info">Agregar Material</button>
    	              </div>
                  @endif
                </div>
            </div>
              <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Código de Material</th>
                      <th>Nombre</th>
                      <th>Cantidad</th>
                      <th>Unidad de presentación</th>
                      <th>Precio U$D</th>
                      <th>Precio AR$</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @forelse($provider_prices as $provider_price)
                        <tr>
                            <td>{{$provider_price->material->code}}</td>
                            <td>{{ $provider_price->material->name }}</td>
                            <td>{{ $provider_price->amount }}</td>
                            <td>{{$provider_price->unit}} {{$provider_price->presentation}}</td>
                            <td>{{ $provider_price->usd_price }}</td>
                            <td>{{ $provider_price->ars_price }}</td>
                            @if (auth()->user()->can('deletecust', auth()->user()))
                            <td><button wire:click="updatemat({{ $provider_price->id }})" type="button" class="btn btn-success btn-sm">Actualizar</button></td>
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
            <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Historial de precios del Proveedor</h3>
              </div>
              <!-- /.card-header -->
             
              <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Código de material </th>
                      <th>Nombre</th>
                      <th>Precio en U$D</th>
                    </tr>
                  </thead>
                  <tbody>
                  
              @forelse($prices as $price)
                  
                  <tr>
                      <td>{{ $price->date }}</td>
                      <td>{{ $price->provider_price->material->code }}</td>
                      <td>{{ $price->provider_price->material->name }}</td>
                      <td>{{ $price->price }}</td>
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
</div>