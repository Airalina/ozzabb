<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Información sobre el Material: {{ $material['name'] }}</h3>
        </div>
        <form>
            <div class="card-body">
                <x-form-validation-errors :errors="$errors" />
                <x-form-create-material :familySelected="$familySelected" :materialContent="$materialContent" :searchTerminal="$searchTerminal" :searchSeal="$searchSeal"
                    :information="$information" :explorar="$explorar" />
                <div class="form-group">
                    <label for="exampleInputFile">Imagen</label>
                    @if ($errors->has('upload.images.*'))
                        <x-image-validation-errors :errors="$errors->get('upload.images.*')" />
                    @endif
                    <div class="input-group">
                        <div class="custom-file">
                            <input wire:model="upload.images" type="file" name="images[]" class="custom-file-input"
                                multiple>
                            <label class="custom-file-label" for="exampleInputFile" data-browse="Elegir">Selecciona las
                                imágenes</label>

                        </div>
                    </div>
                    <div>
                        <x-img-create-card :files="$files" :funcion="$funcion" />
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <td><button wire:click="update({{ $material['id'] }})" type="button" class="btn btn-primary">Guardar
                        Cambios</button>
                </td>
                <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>

        </form>
    </div>
</div>
