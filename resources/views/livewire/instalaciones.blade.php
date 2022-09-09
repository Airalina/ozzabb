<div>
    @switch($view)
        @case('')
            @if (auth()->user()->can('seeinstall', auth()->user()))
                @include('instalacion.lista')
            @endif
        @break

        @case('create')
            @include('instalacion.create')
        @break

        @case('explora')
            @include('instalacion.explora')
        @break

        @case('newrevision')
            @include('instalacion.revision')
        @break

        @case('updateRevision')
            @include('instalacion.revisionupd')
        @break

        @case('listadoDetail')
            @include('instalacion.revisioneslista')
        @break

        @case('update')
            @include('instalacion.update')
        @break
    @endswitch
</div>
