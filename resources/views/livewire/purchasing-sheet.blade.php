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

    @case("viewdetail")
        @include("pucharsing-sheet.purchasingdetail")
        @break

    @case("explora")
        @include("pucharsing-sheet.explora")
        @break
  @endswitch

  
</div>
