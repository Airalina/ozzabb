<div>
  @include("rol.listado")
  @switch($funcion)
      @case("crear")
          @include("rol.registro")
          <button wire:click="store()" type="button" class="btn btn-info">Guardar Cambios</button>
          @break

      @case("adaptar")
          @include("rol.registro")
          <button wire:click="editar()" type="button" class="btn btn-info">Guardar Cambios</button>
          @break

  @endswitch
</div>
