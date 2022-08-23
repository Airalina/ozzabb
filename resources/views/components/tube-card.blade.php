<div class="form-group">
    <label for="tube_type">Tipo</label>
    <select class="form-control form-control-sm" wire:model="tube.type" id="tube_type" wire:change="selectType" {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un tipo</option>
        @foreach ($content['types'] as $type)
        <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="tube_diameter">Diámetro</label>
    <input type="text" class="form-control" id="tube_diameter" wire:model="tube.diameter"
        placeholder="Diámetro del tubo en milímetros (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="wall_thickness">Espesor de pared</label>
    <input type="text" class="form-control" id="wall_thickness" wire:model="tube.wall_thickness"
        placeholder="Grosor de la pared del tubo en mm (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
@if ($content['addFields'])
<div class="form-group">
    <label for="contracted_diameter">Diámetro Contraído</label>
    <input type="text" class="form-control" id="contracted_diameter" wire:model="tube.contracted_diameter"
        placeholder="Diámetro del tubo una vez contraído (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="minimum_temperature">Temperatura mínima de Servicio</label>
    <input type="text" class="form-control" id="minimum_temperature" wire:model="tube.minimum_temperature"
        placeholder="Temperatura mínima de Servicio (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="maximum_temperature">Temperatura máxima de Servicio</label>
    <input type="text" class="form-control" id="maximum_temperature" wire:model="tube.maximum_temperature"
        placeholder="Temperatura máxima de Servicio (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
@endif