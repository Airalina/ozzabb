<div>
    <table>
    <tr>
        <th>
            <h4>Roles del usuario: </h4>
        </th>
        <th>    
            <input id="nombre_y_apellido" wire:model="nombre_y_apellido" type="text" maxlength="200" readonly/>
        </th>
    </tr>
    </table>
    <div class="card-body table-responsive p-0" style="height: 300px;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                @forelse($roles as $rol)
                    <tr>
                      <td>{{ $rol->nombre }}</td>
                        <td> <button wire:click="asignarols({{$rol->id }})" type="button" class="btn btn-success">Asignar Rol</button> </td>    
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