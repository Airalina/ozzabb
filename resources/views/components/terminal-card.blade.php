<div class="form-group">
    <label for="size">Tamaño</label>
    <input type="text" class="form-control" id="size" wire:model="terminal.size"
        placeholder="Tamaño en mm (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="minimum_section">Sección mínima agrafado</label>
    <input type="text" class="form-control" id="minimum_section" wire:model="terminal.minimum_section"
        placeholder="Sección mínima (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="maximum_section">Sección máxima agrafado</label>
    <input type="text" class="form-control" id="maximum_section" wire:model="terminal.maximum_section"
        placeholder="Sección máxima (para decimales usar 'punto(.)')" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="term_material">Material</label>
    <select class="form-control form-control-sm" wire:model="terminal.material" id="term_material" {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un material</option>
        @foreach ($content['materials'] as $material)
        <option value="{{ $material }}">{{ $material }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="term_type">Tipo</label>
    <select class="form-control form-control-sm" wire:model="terminal.type" id="term_type" {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un tipo</option>
        @foreach ($content['types'] as $type)
        <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>
</div>