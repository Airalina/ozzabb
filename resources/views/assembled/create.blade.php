<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Agregar Ensamblado</h3>
        </div>
        <form>
            <div class="card-body">
                <x-form-validation-errors :errors="$errors" />
                <x-form-create-assembled :searchMaterials="$searchMaterials" :materials="$materials" :materialsSelected="$materialsSelected" />
            </div>
            <div class="card-footer">
                <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar</button></td>
                <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>
        </form>
    </div>
</div>
<x-modal-select-material :material="$material" />
