<div class="form-group">
    <label for="accessory_type">Tipo</label>
    <select class="form-control form-control-sm" wire:model="accessory.type" id="accessory_type"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un tipo</option>
        @foreach ($content['types'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
