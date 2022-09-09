<div wire:ignore.self class="modal" id="form-material" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form wire.submit.prevent="addmaterial">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-form-validation-errors :errors="$errors" />
                    @if (count($material) > 0)
                        <div class="form-group">
                            <p><label>Código: </label> {{ $material['code'] }}</p>
                        </div>
                        <div class="form-group">
                            <p><label>Descripción: </label> {{ $material['description'] }}</p>
                        </div>
                        <div class="form-group">
                            <label>Cantidad:</label>
                            <input wire:model.defer="material.amount" type="number" min="0">
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" wire:click.prevent="addMaterial()"
                        class="btn btn-primary btn-sm">Agregar</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"
                        wire:click.prevent="backModal()">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
