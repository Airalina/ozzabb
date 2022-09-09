<h5>Datos de Instalación</h5>
<x-form-create-installation disabled='disabled' showfields='0' />
<h5>Datos de Revisión</h5>
<div class="form-group">
    <label>N° de revisión</label>
    <input class="form-control form-control-sm" wire:model="revision.number_version"
        placeholder="N° de revisión" disabled>
</div>
<div class="form-group">
    <label>Razón</label>
    <textarea class="form-control form-control-sm" style="width: 300px" wire:model="revision.reason"
        placeholder="Razon de revisión ..." {{ $disabled }}></textarea>
</div>
<div class="form-group">
    <label>Fecha de Ingreso</label>
    <input type="date" wire:model="revision.create_date" class="form-control form-control-sm" style="width: auto"
        placeholder="dd/mm/AAAA"  {{ $disabled }}>
</div>
