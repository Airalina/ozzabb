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
        ordenes_explora
    @case("ordenes")
        @include("pucharsing-sheet.orders")
        @break
        
    @case("ordenes_explora")
        @include("pucharsing-sheet.orders_detail")
        @break

    @case("explora")
        @include("pucharsing-sheet.explora")
        @break
  @endswitch

  
</div>
