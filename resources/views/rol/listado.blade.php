<div class="grilla">
  
<div class="card-header">
          <h3 class="card-title">Roles Registrados</h3>
          <div class="card-tools">
            <div>
              @if (auth()->user()->can('store', auth()->user()))
    	        <button wire:click="funcion()" type="button" class="btn btn-info">Agregar Rol</button> 
              @endif
            </div>
            <div class="input-group input-group-sm" style="width: 150px;">
              <input wire:model="search" type="text" class="form-control float-right" placeholder="Buscar Rol...">
            </div>
          </div>
        </div>
         {{ $search }}
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($roles as $rol)
                  <tr class="registros" >
                      <td wire:click="verpermisos({{ $rol->id }})">{{ $rol->id }}</td>
                      <td wire:click="verpermisos({{ $rol->id }})">{{ $rol->nombre }}</td>
                      <td>
                          @if (auth()->user()->can('delete', auth()->user()))
                            <button wire:click="destruir({{ $rol->id }})" type="button" class="btn btn-danger">Borrar</button>
                          @endif
                          @if (auth()->user()->can('update', auth()->user()))
                            <button wire:click="update({{ $rol->id }})" type="button" class="btn btn-primary">Actualizar</button>
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
</div>