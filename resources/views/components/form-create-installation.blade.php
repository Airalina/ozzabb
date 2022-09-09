<div class="form-group">
    <label>Código</label>
    <input class="form-control form-control-sm" type="text" wire:model="installation.code"
        placeholder="Ingrese código de instalación" {{ $disabled }}>
</div>
<div class="form-group">
    <label>Descripción</label>
    <textarea class="form-control form-control-sm" rows="3" wire:model="installation.description"
        placeholder="Descripción ..." {{ $disabled }}></textarea>
</div>
@if ($showfields)
    <x-selection-list-customers :searchCustomers="$customersData['searchCustomers']" :customers="$customersData['customers']" 
        :customerSelected="$customersData['customerSelected']" :showSelection="$disabled"  />
    <div class="form-group">
        <label>Precio U$D</label>
        <input class="form-control form-control-sm" type="text" wire:model="installation.usd_price"
            placeholder="Ingrese precio en dolares (para decimales usar 'punto(.)')" {{ $disabled }}>
    </div>
    <div class="form-group">
        <label>Fecha de Ingreso</label>
        <div class="row">
            <div class="col-4">
                <input type="date" wire:model="installation.date_admission" class="form-control form-control-sm"
                    style="width: auto;" placeholder="dd/mm/AAAA" {{ $disabled }}>
            </div>
        </div>
    </div>
@endif
