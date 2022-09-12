<x-selection-list-customers :searchCustomers="$customersData['searchCustomers']" :customers="$customersData['customers']" :customerSelected="$customersData['customerSelected']" showSelection="" />
@if (!empty($customersData['customerSelected']))
    <x-list-customer-address :addresses="$customersData['customerSelected']['addresses']" :addressSelected="$domicileDelivery" />
    <x-modal-new-address :cliente="$customer" />
@endif
<div class="form-group">
    <label for="deadline">Fecha estimada de entrega</label>
    <div class="row">
        <div class="col-3">
            <input type="date" wire:model="order.deadline" name="deadline" id="deadline"
                class="form-control form-control-sm" placeholder="dd/mm/AAAA">
        </div>
    </div>
</div>

<x-selection-list-installations :searchInstallations="$searchInstallations" :installations="$installations" :installationsSelected="$installationsSelected" />
