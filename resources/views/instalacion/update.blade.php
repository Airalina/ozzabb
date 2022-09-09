<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Actualizar Instalación</h3>
        </div>
        <form>
            <div class="card-body">
                <h5>Datos de Instalación</h5>
                <br>
                <x-form-validation-errors :errors="$errors" />
                <x-form-create-installation :customersData="$customersData" />
            </div>
            <div class="card-footer">
                <td><button wire:click="update({{ $installation['id'] }})" type="button" class="btn btn-primary">Guardar </button></td>
                <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>
    </div>
</div>
<x-modal-select-material :material="$material" />
