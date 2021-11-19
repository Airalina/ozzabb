@if ($lineId != null)
    <option value="{{ $lineId->id }}" selected>{{ $lineId->name }}</option>
@else
    <option selected>Seleccione una línea</option>
@endif
@foreach ($infoLine as $ln)
    @if ($lineId != null)
        @if ($lineId->id === $ln->id)
            @php continue;  @endphp
        @endif
    @endif
    <option value="{{ $ln->id }}">{{ $ln->name }}</option>
@endforeach
