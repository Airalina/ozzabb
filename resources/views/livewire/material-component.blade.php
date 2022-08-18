<div>
    
    @switch($funcion)
    @case("")
        @if (auth()->user()->can('seeproviders', auth()->user()))
          @include("material.listado")
        @endif
        @break

    @case("crear")
        @include("material.registro")
        @break

    @case("actualizar")
        @include("material.actualizar")
        @break
    
    @case("explorar")
        @include("material.explorar")
        @break

    @case("crearPrecio")
        @include("material.registromat")      
        @break
    
    @case("actualizarPrecio")
        @include("material.registromat")      
        @break

  @endswitch

</div>
