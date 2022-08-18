@if (!empty($familySelected))
    @switch($familySelected)
        @case('Conectores')
            <x-connector-card :materialContent="$materialContent['Conectores']" :searchTerminal="$searchTerminal" :searchSeal="$searchSeal" :explorar="$explorar" />
        @break

        @case('Cables')
            <x-cable-card :materialContent="$materialContent['Cables']" :explorar="$explorar" />
        @break

        @case('Terminales')
            <x-terminal-card :materialContent="$materialContent['Terminales']" :explorar="$explorar" />
        @break

        @case('Sellos')
            <x-seal-card :explorar="$explorar" />
        @break

        @case('Tubos')
            <x-tube-card :materialContent="$materialContent['Tubos']" :explorar="$explorar" />
        @break

        @case('Accesorios')
            <x-accesory-card :materialContent="$materialContent['Accesorios']" :explorar="$explorar" />
        @break

        @case('Clips')
            <x-clip-card :materialContent="$materialContent['Clips']" :explorar="$explorar" />
        @break
    @endswitch

    @if ($showReplace)
        <x-replace-card :replaces="$replaces" :explorar="$explorar" />
    @endif
@endif

