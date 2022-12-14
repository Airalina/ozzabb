<div class="grilla">

<div class="card-header"> 
          <h3 class="card-title">Usuarios Registrados</h3>
          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input wire:model="search" type="text" class="form-control float-right" placeholder="Buscar Usuario...">
            </div>
          </div>
</div>
<div class="card-header">
          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              @if (auth()->user()->can('store', auth()->user()))
                <button wire:click="funcion()" type="button" class="btn btn-info btn-sm">Agregar Usuario</button>
              @endif
            </div>  
          </div>
</div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-hover  table-sm">
            <div class="form-group" data-select2-id="45">
                  <label>Ordenar por...</label>
                  <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;"  tabindex="-1" aria-hidden="true">
                    <option data-select2-id="47" value="id">Id</option>
                    <option data-select2-id="48" value="name">Nombre</option>
                    <option data-select2-id="49" value="nombre_y_apellido">Nombre y Apellido</option>
                    <option data-select2-id="50" value="dni">D.N.I.</option>
                    <option data-select2-id="51" value="email">Email</option>
                    <option data-select2-id="52" value="telefono">Telefono</option>
                    <option data-select2-id="53" value="domicilio">Domicilio</option>
                  </select>
                </div>
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
                  <tr>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->nombre_y_apellido }}</td>
                      <td>{{ $user->domicilio }}</td>
                      <td>{{ $user->telefono }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                          <button type="button" wire:click="rolusuario({{ $user->id }})" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i>    Ver</button>
                          @if (auth()->user()->can('update', auth()->user()))
                            <button wire:click="update({{ $user->id }})" type="button" class="btn btn-success btn-sm">Actualizar</button>
                          @else
                            <button  type="button" class="btn btn-secondary btn-sm">Actualizar</button>
                          @endif
                          @if (auth()->user()->can('delete', auth()->user()))
                            <button wire:click="destruir({{ $user->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button>
                          @else
                            <button  type="button" class="btn btn-secondary btn-sm">Borrar</button>
                          @endif 
                      </td>
                      
              </tr>
      @empty
          <tr class="text-center">
              <td colspan="4" class="py-3 italic">No hay informaci??n</td>
          </tr>
  @endforelse 
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        @include('borrar')
</div>