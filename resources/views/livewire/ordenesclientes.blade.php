<div>
    @switch($view)
        @case('')
            @if (auth()->user()->can('seepedidos', auth()->user()))
                @include('pedidos.listado')
            @endif
        @break

        @case('create')
            @include('pedidos.create')
        @break

        @case('update')
            @include('pedidos.update')
        @break

        @case('explorar')
            @include('pedidos.order')
        @break

    @endswitch

</div>
