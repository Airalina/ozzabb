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
                @if (auth()->user()->can('store', auth()->user()))
                    <th>Acciones</th>
                @endif
              </tr>
            </thead>
            <tbody>
                @forelse($roles as $rol)
                    <tr>
                        <td>{{ $rol->nombre }}</td>
                        @if (auth()->user()->can('store', auth()->user()))
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