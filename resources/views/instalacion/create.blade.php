<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Agregar Instalación</h3>
        </div>
        <form>
            <div class="card-body">
                <h5>Datos de Instalación</h5>
                <br>
                <x-form-validation-errors :errors="$errors" />
                <x-form-create-installation :customersData="$customersData" />
                <div class="form-group">
                    <label for="exampleInputFile">Plano de instalación</label>
                    @if ($errors->has('installation.image'))
                        <x-image-validation-errors :errors="$errors->get('installation.image')" />
                    @endif
                    <div class="input-group">
                        <div class="custom-file">
                            <input wire:model="installation.image" type="file" name="image"
                                class="custom-file-input">
                            <label class="custom-file-label" for="exampleInputFile" data-browse="Elegir">Seleccione el
                                plano de instalación</label>
                        </div>
                    </div>
                    <x-img-create-card :files="$files" :funcion="$view" />
                </div>
                <x-selection-list-materials :searchMaterials="$searchMaterials" :materials="$materials" :materialsSelected="$materialsSelected" />
            </div>
            <div class="card-footer">
                <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>
    </div>
</div>
<x-modal-select-material :material="$material" />
