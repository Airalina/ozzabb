<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Agregar Material</h3>
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
                @error('showPrice')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="form-group">
                    <label for="name">¿Desea agregar precio al material?</label>
                    <div class="form-check">
                        <input type="radio" name="price" class="form-check-input" wire:model="showPrice"
                            value="yes">
                        <label for="price" class="form-check-label">Si</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="price" class="form-check-input" wire:model="showPrice"
                            value="no">
                        <label for="price" class="form-check-label">No</label>
                    </div>
                </div>
                @if ($showPrice == 'yes')
                    <x-form-provider-price :searchproviders="$searchproviders" :providers="$providers" :addprovider="$addProvider"
                        :providerselected="$providerSelected" />
                @endif
            </div>

            <div class="card-footer">
                <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar</button></td>
                <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>

        </form>
    </div>
</div>
<x-modal-provider-price />
