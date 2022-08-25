<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"> Material código: {{ $material['code'] }} </h3>
        </div>
        <div class="card-body">
            <x-form-create-material :familySelected="$familySelected" :materialContent="$materialContent" :searchTerminal="$searchTerminal" :searchSeal="$searchSeal"
                :information="$information" :explorar="$explorar" />
            <x-img-create-card :files="$files" :funcion="$funcion" />
            <x-list-prices-card type="material" :item="$material" :providerPrices="$providerPrices" permission="storematerial" :arPrice="$ar_price" />
        </div>
    </div>
</div>
