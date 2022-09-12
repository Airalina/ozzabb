<div wire:ignore.self class="modal" id="form-address" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form wire.submit.prevent="addaddress">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registro de domicilio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-form-validation-errors :errors="$errors" />
                    <livewire:clientes component="orders" funcion="createAddress" :cliente="$cliente" />
                </div>
            </div>
        </form>
    </div>
</div>
