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
        
    @case("crearmat")
        @include("material.registromat")      
        @break
    
    @case("actualizarmat")
        @include("material.registromat")      
        @break
    

    @case("actualizar")
        @include("material.registro")
        @break

  @endswitch

  @switch($explora)
      @case("activo")
          @include("material.explorar")
          @break
  @endswitch


</div>
