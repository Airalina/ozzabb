<div>
  @include("rol.listado")
  @switch($funcion)
      @case("crear")
          @include("rol.registro")
          <button wire:click="store()">Guardar Cambios</button>
          @break

      @case("adaptar")
          @include("rol.registro")
          <button wire:click="editar()">Guardar Cambios</button>
          @break

  @endswitch
</div>
