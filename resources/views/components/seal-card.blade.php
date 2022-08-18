<div class="form-group">
    <label for="minimum_diameter">Diámetro mínimo de Cable</label>
    <input type="text" class="form-control" id="minimum_diameter" wire:model="seal.minimum_diameter"
        placeholder="Diámetro mínimo de Sello (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="maximum_diameter">Diámetro máximo de Cable</label>
    <input type="text" class="form-control" id="maximum_diameter" wire:model="seal.maximum_diameter"
        placeholder="Diámetro máximo de Cable (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="seal_type">Tipo</label>
    <input type="text" class="form-control" id="seal_type" wire:model="seal.type" placeholder="Tipo de sello" {{ $explorar['readonly'] }}>
</div>