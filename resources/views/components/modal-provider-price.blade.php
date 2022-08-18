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
                    <div class="form-group">
                        <label for="name_provider">Nombre de la empresa</label>
                        <input type="text" class="form-control form-control-sm" id="name_provider"
                            wire:model.defer="provider.name" placeholder="Nombre de la empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="address_provider">Domicilio</label>
                        <input type="text" class="form-control form-control-sm" id="address_provider"
                            wire:model.defer="provider.address" placeholder="Domicilio" required>
                    </div>
                    <div class="form-group">
                        <label for="email_provider">Correo electrónico para ventas</label>
                        <input type="email" class="form-control form-control-sm" id="email_provider"
                            wire:model.defer="provider.email" placeholder="Correo electrónico para ventas"
                            required>
                    </div>
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