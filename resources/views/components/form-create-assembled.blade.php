<div class="form-group">
    <label>Descripción</label>
    <textarea class="form-control form-control-sm" rows="3" wire:model="assembled.description" style="width: 300px"
        placeholder="Descripción ..."></textarea>
</div>
<div class="form-group">
    <label>Fecha de Ingreso</label>
    <input type="date" wire:model="assembled.create_date" class="form-control form-control-sm" style="width: auto"
        placeholder="dd/mm/AAAA">
</div>

<x-selection-list-materials :searchMaterials="$searchMaterials" :materials="$materials" :materialsSelected="$materialsSelected" />