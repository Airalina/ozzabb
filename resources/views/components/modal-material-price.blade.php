<div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form wire.submit.prevent="addproviderprice">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-form-validation-errors :errors="$errors" />
                    <x-form-create-material :familySelected="$familySelected" :materialContent="$materialContent" :searchTerminal="$searchTerminal" :searchSeal="$searchSeal"
                        :information="$information" :explorar="$explorar" />

                    <div class="modal-footer">
                        <button wire:click.prevent="storeMaterial()" type="submit"
                            class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-primary" wire:click.prevent="backModal()"  data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
        </form>
    </div>
</div>
