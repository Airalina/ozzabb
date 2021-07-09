<div class="grilla">

<div class="card-header">
          
          <h3 class="card-title">Usuarios Registrados</h3>
          <div class="card-tools">
            <div>
    	        <button wire:click="funcion()" type="button" class="btn btn-info">Agregar Usuario</button> 
            </div>
            <div class="input-group input-group-sm" style="width: 150px;">
              <input wire:model="search" type="text" class="form-control float-right" placeholder="Buscar Usuario...">
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
                <th>Usuario</th>
                <th>nombre_y_apellido</th>
                <th>Domicilio</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                  <tr class="registros">
                      <td wire:click="rolusuario({{ $user->id }})">{{ $user->id }}</td>
                      <td wire:click="rolusuario({{ $user->id }})">{{ $user->name }}</td>
                      <td wire:click="rolusuario({{ $user->id }})">{{ $user->nombre_y_apellido }}</td>
                      <td wire:click="rolusuario({{ $user->id }})">{{ $user->domicilio }}</td>
                      <td wire:click="rolusuario({{ $user->id }})">{{ $user->telefono }}</td>
                      <td wire:click="rolusuario({{ $user->id }})">{{ $user->email }}</td>
                      <td>
                          <button wire:click="destruir({{ $user->id }})" type="button" class="btn btn-danger">Borrar</button>
                          <button wire:click="update({{ $user->id }})" type="button" class="btn btn-primary">Actualizar</button>
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