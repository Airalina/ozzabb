<div class="card-body table-responsive p-0">
    
    <table class="table table-hover text-nowrap">
                  <thead>
                    
                    <div class="card-tools">
                    <div>
                      <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
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

       
</div>