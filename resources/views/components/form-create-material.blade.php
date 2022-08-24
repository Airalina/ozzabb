<div class="form-group">
    <label for="code">Código del material</label>
    <input type="text" class="form-control" id="code" wire:model="material.code" placeholder="Código del material"
        required {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="name">Nombre del material</label>
    <input type="text" class="form-control" id="name" wire:model="material.name"
        placeholder="Nombre del material" required {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="family">Familia</label>
    <select class="form-control form-control-sm" wire:model="material.family" id="family"
        {{ $explorar['familyDisabled'] }}>
        <option selected value="" hidden>Selecciona una familia</option>
        @foreach ($information['families'] as $name => $family)
            <option>{{ $name }}</option>
        @endforeach
    </select>
</div>

<x-material-card :familySelected="$familySelected" :materialContent="$materialContent" :showReplace="$information['showReplace']" :replaces="$information['replaces']" :searchTerminal="$searchTerminal"
    :searchSeal="$searchSeal" :explorar="$explorar" />

<div class="form-group">
    @if ($information['showColors'])
        <label for="color">Color</label>
        <select class="form-control form-control-sm" wire:model="material.color" id="color"
            {{ $explorar['disabled'] }}>
            <option selected value="" hidden>Selecciona un color</option>
            @foreach ($information['colors'] as $color)
                <option value="{{ $color['name'] }}" style="color:{{ $color['value'] }}">
                    {{ $color['name'] }}
                </option>
            @endforeach
        </select>
    @endif
</div>
<div class="form-group">
    <label for="description">Descripción</label>
    <textarea name="description" class="form-control" wire:model="material.description" id="description" cols="30"
        rows="3" {{ $explorar['readonly'] }}></textarea>
</div>
<div class="form-group">
    @if ($information['showLines'])
        <label for="line">Línea</label>
        <select class="form-control form-control-sm" wire:model="material.line" id="line"
            {{ $explorar['disabled'] }}>
            <option selected value="" hidden>Selecciona una linea</option>
            @foreach ($information['lines'] as $index => $line)
                <option>{{ $line }}</option>
            @endforeach
        </select>
    @endif
</div>
<div class="form-group">
    <label for="usage">Uso</label>
    <select wire:model="material.usage" id="usage" class="form-control form-control-sm"
        {{ $explorar['disabled'] }}>
        <option selected value="" hidden>Selecciona un uso</option>
        @foreach ($information['usages'] as $index => $usage)
            <option>{{ $usage }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="stock_min">Stock mínimo</label>
    <input type="text" class="form-control" id="stock_min" wire:model="material.stock_min"
        placeholder="Stock mínimo del material" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="stock_max">Stock máximo</label>
    <input type="text" class="form-control" id="stock_max" wire:model="material.stock_max"
        placeholder="Stock máximo del material" {{ $explorar['readonly'] }}>
</div>
<div class="form-group">
    <label for="stock">Stock en planta</label>
    <input type="text" class="form-control" id="stock" wire:model="material.stock"
        placeholder="En órdenes de ingresos y egresos" readonly>
</div>
@if ($explorar['disabled'] == 'disabled')
    <div class="form-group">
        <label for="stock">Stock en tránsito</label>
        <input type="text" class="form-control" id="stock" wire:model="material.stock_transit"
            placeholder="Stock en tránsito" readonly>
    </div>
@endif
