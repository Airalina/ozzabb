<div class="form-group">
    <label for="accesory_type">Tipo</label>
    <select class="form-control form-control-sm" wire:model="accesory.type" id="accesory_type"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un tipo</option>
        @foreach ($content['types'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
