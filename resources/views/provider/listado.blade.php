<div>
<div class="card card-tabs">
            <div class="card-header">
                <h3 class="card-title">Proveedores Registrados</h3>
                <div class="card-tools">
                  @if (auth()->user()->can('storeprovider', auth()->user()))
                    <div>
                      <button wire:click="funcion()" type="button" class="btn btn-info">Agregar Proveedor</button>
    	              </div>
                  @endif
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input wire:model="search" type="text" class="form-control float-right" placeholder="Buscar Proveedor...">
                    </div>
                </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table class="table table-head text-nowrap">
                <div class="form-group" data-select2-id="45">
                  <label>Ordenar por</label>
                  <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;"  tabindex="-1" aria-hidden="true">
                    <option data-select2-id="47" value="id">Id</option>
                    <option data-select2-id="48" value="name">Nombre</option>
                    <option data-select2-id="49" value="address">Dirección</option>
                    <option data-select2-id="50" value="phone">Teléfono</option>
                    <option data-select2-id="51" value="email">Email</option>
                    <option data-select2-id="52" value="contact_name">Nombre de contacto</option>
                    <option data-select2-id="53" value="point_contact">Puesto de contacto</option>
                    <option data-select2-id="54" value="site_url">Página web</option>
                  </select>
                </div>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Domicilio</th>
                      <th>Teléfono</th>
                      <th>Correo electrónico</th>
                      <th>Nombre de contacto</th>
                      <th>Puesto de contacto</th>
                      <th>Página web</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  
            <tbody>
              @forelse($providers as $provider)
                <tr class="registros">
                      <td>{{ $provider->id }}</td>
                      <td>{{ $provider->name }}</td>
                      <td>{{ $provider->address }}</td>
                      <td>{{ $provider->phone }}</td>
                      <td>{{ $provider->email }}</td>
                      <td>{{ $provider->contact_name }}</td>
                      <td>{{ $provider->point_contact }}</td>
                      <td>{{ $provider->site_url }}</td>
                      @if($provider->status==1)
                        <td>Activo</td>
                      @else
                        <td>Inactivo</td>
                      @endif
                      <td >
                        <button type="button" wire:click="explorar({{ $provider->id }})" class="btn btn-primary btn-xs"><i class="fas fa-file-alt"></i>    Ver</button>
                        @if (auth()->user()->can('updateprovider', auth()->user()))
                            <button wire:click="update({{ $provider->id }})" type="button" class="btn btn-success btn-xs">Actualizar</button>
                          @endif
                        @if (auth()->user()->can('deleteprovider', auth()->user()))
                            <button wire:click="destruir({{ $provider->id }})" type="button" class="btn btn-danger btn-xs">Borrar</button>
                          @endif
                
                            
                      </td>      
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
</div>
