<div class="grilla">

<div class="card-header">
          
          <h3 class="card-title">Usuarios Registrados</h3>
          <div class="card-tools">
            <div>
    	        <button wire:click="funcion()">Agregar Usuario</button> 
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
                  <tr class="registros" wire:click="rolusuario({{ $user->id }})">
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->nombre_y_apellido }}</td>
                      <td>{{ $user->domicilio }}</td>
                      <td>{{ $user->telefono }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                          <button wire:click="destruir({{ $user->id }})">Borrar</button>
                          <button wire:click="update({{ $user->id }})">Actualizar</button>
                      
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