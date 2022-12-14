<div>
<div class="card">
            <div class="card-header">
                <h3 class="card-title">Clientes Registrados</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input wire:model="search" type="text" class="form-control float-right" placeholder="Buscar Cliente...">
                    </div>
                </div>
            </div>
            <div class="card-header">
                <div>  
                      <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" min="1" wire:model="paginas" class="form-control">
                </div>
                <div class="card-tools">
                  @if (auth()->user()->can('storecust', auth()->user()))
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <button wire:click="funcion()" type="button" class="btn btn-info btn-sm">Agregar Cliente</button>
    	              </div>
                  @endif
                </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table class="table table-hover table-sm">
                <div class="form-group" data-select2-id="45">
                    <label>Ordenar por</label>
                    <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="48" value="name">Nombre</option>
                        <option data-select2-id="49" value="domicile_admin">Dirección</option>
                        <option data-select2-id="50" value="phone">Teléfono</option>
                        <option data-select2-id="51" value="email">Email</option>
                        <option data-select2-id="52" value="state">Estado</option>
                    </select>
                </div>
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Teléfono</th>
                      <th>Email</th>
                      <th>Domicilio Administración</th>
                      <th>Estado</th>
                      <th></th>
                    </tr>
                  </thead>
                  
            <tbody>
              @forelse($clientes as $cliente)
                <tr class="registros">
                      <td>{{ $cliente->name }}</td>
                      <td>{{ $cliente->phone }}</td>
                      <td>{{ $cliente->email}}</td>
                      <td>{{ $cliente->domicile_admin}}</td>
                      @if($cliente->estado==true)
                        <td>Activo</td>
                      @else
                        <td>Inactivo</td>
                      @endif
                      <td >
                        <button type="button" wire:click="explorar({{ $cliente->id }})" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i>    Ver</button>
                        @if (auth()->user()->can('updatecust', auth()->user()))
                          <button wire:click="update({{ $cliente->id }})" type="button"  class="btn btn-success btn-sm">Actualizar</button>
                        @endif
                        @if (auth()->user()->can('deletecust', auth()->user())) 
                          <button wire:click="destruir({{ $cliente->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button>
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
                {{ $clientes->links() }}
              </div>
              <!-- /.card-body -->
            </div>
            @include('borrar')
</div>
