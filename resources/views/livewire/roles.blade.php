<div id="create">

  @switch($funcion)
    @case("")
        @if (auth()->user()->can('seerol', auth()->user()))
          @include("rol.listado")
        @endif
        @break

    @case("crear")
        @include("rol.registro")
        <div class="card-footer">
            <th>
              <td><button wire:click="store()" type="button" class="btn btn-primary">Crear Rol</button></td>
              <td><button wire:click="endfunctions()" type="button" class="btn btn-primary">Cancelar</button></td>
            </th>
        </div>
        @break

    @case("adaptar")
        @include("rol.registro")
          <div class="card-footer">
            <th>
              <td><button wire:click="editar()" type="button" class="btn btn-primary">Guardar Cambios</button></td>
              <td><button wire:click="endfunctions()" type="button" class="btn btn-primary">Cancelar</button></td>
            </th>
        </div>    
        @break
  
  @endswitch

  @switch($funcionpr)
      @case("asigna")
          @include("rol.permisosrol")
          @break
  @endswitch
</div>
