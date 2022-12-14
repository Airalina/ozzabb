<div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form wire.submit.prevent="addmaterial">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-form-validation-errors :errors="$errors" />
                    <x-form-create-provider modal="true"  />
                    <div class="modal-footer">
                        <button wire:click.prevent="storeProvider()" type="submit"
                            class="btn btn-primary">Guardar
                            Cambios
                        </button>
                        <button type="button" class="btn btn-primary" wire:click.prevent="backModal()"  data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
        </form>
    </div>
</div>