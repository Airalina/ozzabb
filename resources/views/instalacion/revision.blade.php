<div>
    <button wire:click="backToExplorar()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registro de Versiones</h3>
        </div>
        <form>
            <x-form-validation-errors :errors="$errors" />
            <div class="card-body">
                <x-form-revisions />
                <x-selection-list-materials :searchMaterials="$searchMaterials" :materials="$materials" :viewRevisions='1' :materialsSelected="$materialsSelected" />
            </div>
            <div class="card-footer">
                <td><button wire:click="storeRevision({{ $installation['id'] }})" type="button"
                        class="btn btn-primary">Guardar </button></td>
                <td><button wire:click="backToExplorar()" type="button" class="btn btn-primary">Cancelar</button>
                </td>
            </div>
        </form>
    </div>
</div>
<x-modal-select-material :material="$material" />
