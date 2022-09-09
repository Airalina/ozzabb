<div class="form-group">
    <label for="name">Nombre</label>
    <input class="form-control form-control-sm" name="name" id="name" type="text" wire:model="warehouse.name"
        placeholder="Ingrese nombre del deposito" {{ $disabled }}>
</div>
<div class="form-group">
    <label for="location">Ubicación</label>
    <input class="form-control form-control-sm" name="location" id="location" type="text"
        wire:model="warehouse.location" placeholder="Ingrese ubicación del depósito"  {{ $disabled }}>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Descripción</label>
    <textarea class="form-control form-control-sm" rows="3" name="location" id="location"
        wire:model="warehouse.description" placeholder="Descripción ..."  {{ $disabled }}></textarea>
</div>
<div class="form-group">
    <label for="name">Indica si el depósito es permanente o temporal</label>
    <div class="form-check">
        <input type="radio" name="temporary" id="temporary" class="form-check-input" wire:model="warehouse.temporary"
            value="1"  {{ $disabled }}>
        <label for="temporary" class="form-check-label">Temporal</label>
    </div>
    <div class="form-check">
        <input type="radio" name="permanent" id="permanent" class="form-check-input" wire:model="warehouse.temporary"
            value="0"  {{ $disabled }}>
        <label for="permanent" class="form-check-label">Permanente</label>
    </div>
</div>
@if ($showOptions)
    <div class="form-group">
        <label for="type">Tipo de depósito</label>
        <select class="form-control form-control-sm select2 select2-hidden-accessible" name="type" id="type"
            wire:model="warehouse.type" style="width: auto"  {{ $disabled }}>
            <option selected="selected" hidden>Seleccione un tipo de depósito</option>
            @foreach ($types as $index => $type)
                <option value="{{ $index }}">{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="date">Fecha de creación</label>
        <div class="row">
            <div class="col-4">
                <input type="date" wire:model="warehouse.create_date" name="date" id="date"
                    class="form-control form-control-sm" placeholder="dd/mm/AAAA"  {{ $disabled }}>
            </div>
        </div>
    </div>
@endif
