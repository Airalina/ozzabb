<div>
  
  @switch($funcion)
    @case("")
        @if (auth()->user()->can('seecust', auth()->user()))
          @include("provider.listado")
        @endif
        @break

    @case("crear")
        @include("provider.registro")
        @break

    @case("crearmat")
        @include("provider.registromat")      
        @break

    @case("actualizar")
        @include("provider.registro")
        @break
  
  @endswitch

  @switch($explora)
      @case("activo")
          @include("provider.explorar")
          @break
  @endswitch
  
</div>
