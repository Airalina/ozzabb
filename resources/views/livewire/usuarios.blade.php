<div id="create">
  
  @switch($funcion)
    @case("")
        @if (auth()->user()->can('see', auth()->user()))
            @include("user.listado")
        @endif 
        @break

    @case("crear")
        @include("user.registro")
        <div class="card-footer">
            <th>
                <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar Usuario</button></td>
                <td><button wire:click="endfunctions()" type="button" class="btn btn-primary">Cancelar</button></td>
            </th>   
        </div>
        @break

    @case("adaptar")
        @include("user.registro")
        <div class="card-footer">
            <th>
                <td><button wire:click="editar()" type="button" class="btn btn-primary">Guardar Cambios</button></td>
                <td><button wire:click="endfunctions()" type="button" class="btn btn-primary">Cancelar</button></td>
            </th>
        </div>  
        @break

  @endswitch

  @switch($funcionru)
      @case("asigna")
          @include("user.usuariorol")
          @break
  @endswitch
</div>