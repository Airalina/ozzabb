<div class="form-group">
    <label for="amount">Código de Proveedor</label>
    <input class="form-control form-control-sm" type="string" id="provider_code" wire:model="price.provider_code"
        placeholder="Código del proveedor">
</div>
<div class="form-group">
    <label for="amount">Cantidad</label>
    <input class="form-control form-control-sm" type="string" id="amount" wire:model="price.amount"
        placeholder="Ingrese la cantidad">
</div>
<div class="form-group">
    <label for="unit">Packaging</label>
    <div class="d-flex">
        <input class="form-control form-control-sm" type="string" id="unit" wire:model="price.unit"
            placeholder="Ingrese las unidades">
        <select class="form-control form-control-sm" wire:model="price.presentation" id="presentation">
            <option selected value="" hidden>Selecciona una medida</option>
            <option value="m">Metros</option>
            <option value="und">Unidades</option>
            <option value="cajas">Cajas</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="usd_price">Precio U$D</label>
    <input class="form-control form-control-sm" type="text" id="usd_price" wire:model="price.usd_price"
        wire:change="changeArsPrice" placeholder="Ingrese el precio U$D">
</div>
<div class="form-group">
    <label for="ars_price">Precio AR$</label>
    <input class="form-control form-control-sm" type="text" id="ars_price" wire:model="price.ars_price"
        placeholder="Ingrese el precio AR$" disabled>
</div>
