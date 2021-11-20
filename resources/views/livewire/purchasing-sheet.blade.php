<div>
  
  @switch($funcion)
    @case("")
        @if (auth()->user()->can('seeproviders', auth()->user()))
          @include("pucharsing-sheet.listado")
        @endif
        @break

    @case("crear")
        @include("pucharsing-sheet.worksheet")
        @break

    @case("actualizar")
        @include("pucharsing-sheet.worksheet")
        @break

  @endswitch

  @switch($explora)
      @case("activo")
          @include("pucharsing-sheet.explorar")
          @break
  @endswitch
  
</div>
