<div>
    <div>
      <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    </div>
    <br>
    <table class="table table-hover table-sm">
                  <thead>
                    
                    <div class="card-tools">
                    <h5>Usted a seleccionado al usuario: {{ $name }} </h5>
                    </div>
                    <br>
                    <h6> Datos: </h6>
                    <tr>
                      <th>Nombre y Apellido</th>
                      <th>Telefono</th>
                      <th>Email</th>
                      <th>Domicilio </th>
                      <th>D.N.I</th> 
                      <th><th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    <td>{{ $nombre_y_apellido }}</td>
                      <td>{{ $telefono }}</td>
                      <td>{{ $email }}</td>
                      <td>{{ $domicilio }}</td>
                      <td>{{ $dni }}</td>
                    </tr>
                  </tbody>
    </table>
    <br>
    <h6> Roles: </h6>
    <div class="card-body table-responsive p-0" style="height: 300px;">
        <table class="table table-hover table-sm ">
            <thead>
              <tr>
                <th>Nombre</th>
                @if (auth()->user()->can('update', auth()->user()))
                    <th>Acciones</th>
                @endif
              </tr>
            </thead>
            <tbody>
                @forelse($roles as $rol)
                    <tr>
                        <td>{{ $rol->nombre }}</td>
                        @if (auth()->user()->can('update', auth()->user()))
                            @if(sizeof($rol->users()->where('user_id',$idus)->get())==0)
                            <td> <button wire:click="asignarols({{$rol->id }})" type="button" class="btn btn-success">Asignar Rol</button> </td>    
                            @else
                            <td> <button wire:click="quitarol({{$rol->id }})" type="button" class="btn btn-danger">Quitar Rol</button> </td>
                            @endif
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
                   
</div>