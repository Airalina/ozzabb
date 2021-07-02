<div id="create">
  @include("user.listado")
  @switch($funcion)
      @case("crear")
          @include("user.registro")
          <button wire:click="store()">Guardar Cambios</button>
          @break

      @case("adaptar")
          @include("user.registro")
          <button wire:click="editar()">Guardar Cambios</button>
          @break

  @endswitch

</div>