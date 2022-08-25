<div wire:ignore.self class="modal" id="borrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form wire.submit.prevent="addmaterial">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Advertencia.</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                          <p>Usted esta a punto de borrar un registro ¿Realmente desea ejecutar esta acción?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" wire:click.prevent="delete()" class="btn btn-primary btn-sm" >Borrar de todas formas.</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>