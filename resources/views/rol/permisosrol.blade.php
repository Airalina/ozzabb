<div>
    <table>
    <tr>
        <th>
            <h4>Permisos del Rol: </h4>
        </th>
        <th>    
            <h4>{{ $nombre }}</h4>
        </th>
    </tr>
    </table>
    <div class="card-body table-responsive p-0" style="height: 300px;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>Nombre</th>
                @if (auth()->user()->can('updaterol', auth()->user()))
                    <th>Ver</th>
                @endif
                @if (auth()->user()->can('updaterol', auth()->user()))
                    <th>Crear</th>
                @endif
                @if (auth()->user()->can('updaterol', auth()->user()))
                    <th>Adaptar</th>
                @endif
                @if (auth()->user()->can('updaterol', auth()->user()))
                    <th>Eliminar</th>
                @endif
              </tr>
            </thead>
            <tbody>
                @forelse($permisos as $permiso)
                    <tr>
                        <td>{{ $permiso->name }}</td>
                        @if (auth()->user()->can('updaterol', auth()->user()))
                            @if($permiso->see==0)
                            <td> <button wire:click="permisosrolsee({{$permiso->id }})" type="button" class="btn btn-success">Asignar Permiso</button> </td>    
                            @else
                            <td> <button wire:click="quitarpermisosee({{$permiso->id }})" type="button" class="btn btn-danger">Quitar Permiso</button> </td>
                            @endif
                        @endif
                        @if (auth()->user()->can('updaterol', auth()->user()))
                            @if($permiso->create==0)
                                <td> <button wire:click="permisosrolcreate({{$permiso->id }})" type="button" class="btn btn-success">Asignar Permiso</button> </td>    
                            @else
                                <td> <button wire:click="quitarpermisocreate({{$permiso->id }})" type="button" class="btn btn-danger">Quitar Permiso</button> </td>
                            @endif
                        @endif
                        @if (auth()->user()->can('updaterol', auth()->user()))
                            @if($permiso->update==0)
                                <td> <button wire:click="permisosrolupdate({{$permiso->id }})" type="button" class="btn btn-success">Asignar Permiso</button> </td>    
                            @else
                                <td> <button wire:click="quitarpermisoupdate({{$permiso->id }})" type="button" class="btn btn-danger">Quitar Permiso</button> </td>
                            @endif
                        @endif
                        @if (auth()->user()->can('updaterol', auth()->user()))
                            @if($permiso->delete==0)
                                <td> <button wire:click="permisosroldelete({{$permiso->id }})" type="button" class="btn btn-success">Asignar Permiso</button> </td>    
                            @else
                                <td> <button wire:click="quitarpermisodelete({{$permiso->id }})" type="button" class="btn btn-danger">Quitar Permiso</button> </td>
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