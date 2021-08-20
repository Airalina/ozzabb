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
                    <td>{{ $provider->id }}
                      <td>{{ $provider->name }}
                      <td>{{ $provider->address }}
                      <td>{{ $provider->phone }}
                      <td>{{ $provider->email }}
                      <td>{{ $provider->contact_name }}
                      <td>{{ $provider->point_name }}
                      <td>{{ $provider->site_url }}
                      @if($provider->status==1)
                        <td>Activo</td>
                      @else
                        <td>Inactivo</td>
                      @endif
                      <td>
                        @if (auth()->user()->can('updatecust', auth()->user()))
                          <button wire:click="update({{ $provider->id }})" type="button"  class="btn btn-primary btn-sm">Actualizar</button>
                        @endif
                        @if (auth()->user()->can('deletecust', auth()->user())) 
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
                  @if (auth()->user()->can('storecust', auth()->user()))  
                    <div>
                      <button wire:click="agregamat()" type="button" class="btn btn-info">Agregar Material</button>
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
                  @forelse($materials as $material)
                        <tr>
                            <td>{{$material->code}}</td>
                            <td>{{$material->name}}</td>
                            <td>{{$material->stock}}</td>
                            <td>{{$material->unit}} {{$material->presentation}}</td>
                            <td>@if($material->usd_price) ${{$material->usd_price}}  @endif</td>
                            <td>@if($material->ars_price) ${{$material->ars_price}}  @endif</td>
                            @if (auth()->user()->can('deletecust', auth()->user()))
                            <td><button wire:click="destruirmat({{ $material->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button></td>
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