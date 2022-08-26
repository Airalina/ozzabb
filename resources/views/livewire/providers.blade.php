<div>

    @switch($view)
        @case('')
            @if (auth()->user()->can('seeproviders', auth()->user()))
                @include('provider.listado')
            @endif
        @break

        @case('crear')
            @include('provider.registro')
        @break

        @case('actualizar')
            @include('provider.actualizar')
        @break

        @case('crearPrecio')
            @include('provider.registromat')
        @break

        @case('actualizarPrecio')
            @include('provider.registromat')
        @break

        @case('explorar')
            @include('provider.explorar')
        @break

    @endswitch

</div>
