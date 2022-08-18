<div class="form-group">
    <label for="clip_type">Tipo</label>
    <select class="form-control form-control-sm" wire:model="clip.type" id="clip_type"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un tipo</option>
        @foreach ($content['types'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="long">Largo</label>
    <input type="text" class="form-control" id="long" wire:model="clip.long"
        placeholder="Largo en mm (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="width">Ancho</label>
    <input type="text" class="form-control" id="width" wire:model="clip.width"
        placeholder="Ancho en mm (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="hole_diameter">Diámetro del Orificio</label>
    <input type="text" class="form-control" id="hole_diameter" wire:model="clip.hole_diameter"
        placeholder="Diámetro del Orificio (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
