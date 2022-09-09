<div>
    @switch($view)
        @case('')
            @if (auth()->user()->can('seedepo', auth()->user()))
                @include('deposito.lista')
            @endif
        @break

        @case('create')
            @include('deposito.create')
        @break

        @case('explorar')
            @include('deposito.explora')
        @break

        @case('ingreso')
            @include('deposito.ingreso')
        @break

        @case('egreso')
            @include('deposito.egreso')
        @break

        @case('retiros')
            @include('deposito.retiros')
        @break

        @case('retiroDetail')
            @include('deposito.retiro_detail')
        @break

        @case('createMaterial')
            @include('deposito.createMaterial')
        @break
 
        @case('createAssembled')
            @include('deposito.createassembled')
        @break

        @case('createInstallation')
            @include('deposito.createInstallation')
        @break

        @case('createbo')
            @include('deposito.createbo')
        @break

        @case('actualizar')
            @include('deposito.update')
        @break

    @endswitch
</div>
