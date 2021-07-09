<div id="create">
  @include("user.listado")
  @switch($funcion)
      @case("crear")
          @include("user.registro")
          <button wire:click="store()" type="button" class="btn btn-info">Guardar Cambios</button>
          @break

      @case("adaptar")
          @include("user.registro")
          <button wire:click="editar()" type="button" class="btn btn-info">Guardar Cambios</button>
          @break

  @endswitch

  @switch($funcionru)
      @case("asigna")
          @include("user.usuariorol")
          @break
  @endswitch
</div>