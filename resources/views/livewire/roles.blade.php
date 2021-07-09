<div>
  
  @switch($funcion)
      @case("")
          @include("rol.listado")
          @break

      @case("crear")
          @include("rol.registro")
            <th>
                <td><button wire:click="store()" type="button" class="btn btn-primary">Crear Rol</button></td>
                <td><button wire:click="endfunctions()" type="button" class="btn btn-primary">Cancelar</button></td>
            </th>   
          @break

      @case("adaptar")
          @include("rol.registro")
            <th>
                <td><button wire:click="editar()" type="button" class="btn btn-primary">Guardar Cambios</button></td>
                <td><button wire:click="endfunctions()" type="button" class="btn btn-primary">Cancelar</button></td>
            </th>   
          @break

  @endswitch
</div>
