<div id="create">
  
  @switch($funcion)
    @case("")
        @if (auth()->user()->can('seecust', auth()->user()))
          @include("cliente.listado")
        @endif
        @break

    @case("crear")
        @include("cliente.registro")
        @break

    @case("creardom")
        @include("cliente.registrodom")      
        @break

    @case("adaptar")
        @include("cliente.adaptar")
        @break
  
  @endswitch

  @switch($explora)
      @case("activo")
          @include("cliente.explorar")
          @break
  @endswitch
  
</div>
