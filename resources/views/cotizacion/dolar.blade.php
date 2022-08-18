<div class="row">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Administración de moneda</h3>
        </div>
    <form>
        <div class="card-body">
            <div class="form-group">
                <label>Dólar</label><br>
                <input type="number" value=1 disabled>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Pesos argentinos</label><br>
                <input type="number" wire:model="ars_price" disabled>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" wire:click="modifica()"class="btn btn-primary">Modificar</button>
        </div>
    </form>
</div>
<div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form wire.submit.prevent="addmaterial">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificación de Cotización</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Ingrese cotización actual del dolar</label><br>
                        <input type="number" wire:model="new_ars_price" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="update()" class="btn btn-primary btn-sm" >Modificar</button>
                    <button type="button" wire:click.prevent="cancel()" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>