@if ($usageId != null)
    <option value="{{ $usageId->id }}" selected>{{ $usageId->name }}</option>
@else
    <option selected>Seleccione un uso</option>
@endif
@foreach ($infoUsage as $usg)
    @if ($usageId != null)
        @if ($usageId->id === $usg->id)
            @php continue;  @endphp
        @endif
    @endif
    <option value="{{ $usg->id }}">{{ $usg->name }}</option>
@endforeach
