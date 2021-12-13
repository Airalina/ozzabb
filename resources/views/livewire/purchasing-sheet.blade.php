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

    @case("explora")
        @include("pucharsing-sheet.explora")
        @break
  @endswitch

  
</div>
