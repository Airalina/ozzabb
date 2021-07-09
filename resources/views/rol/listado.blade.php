<div class="card-header">
          <h3 class="card-title">Roles Registrados</h3>
          <div class="card-tools">
            <div>
    	        <button wire:click="funcion()" type="button" class="btn btn-info">Agregar Rol</button> 
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
                  <tr class="registros" onclick="">
                      <td>{{ $rol->id }}</td>
                      <td>{{ $rol->nombre }}</td>
                      <td>
                          <button wire:click="destruir({{ $rol->id }})" type="button" class="btn btn-danger">Borrar</button>
                          <button wire:click="update({{ $rol->id }})" type="button" class="btn btn-primary">Actualizar</button>
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