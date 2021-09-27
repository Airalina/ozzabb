<div>
@switch($funcion)
    @case("")
        @if (auth()->user()->can('seedepo', auth()->user()))
            @include("deposito.lista")
        @endif
        @break
    @case("create")
        @include("deposito.create")
        @break
    @case("explora")
        @include("deposito.explora")
        @break
    @case("ingreso")
        @include("deposito.ingreso")
        @break
    @case("egreso")
        @include("deposito.egreso")
        @break
    @case("retiros")
        @include("deposito.retiros")
        @break
    @case("createassembled")
        @include("deposito.createassembled")
        @break
    @case("createbo")
        @include("deposito.createbo")
        @break
@endswitch
</div>
