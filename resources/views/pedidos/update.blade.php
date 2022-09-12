<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="col-md-8">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Actualizar Pedido</h3>
        </div>
        <form>
            <div class="card-body">
                <h5>Datos de Pedido</h5>
                <br>
                <x-form-validation-errors :errors="$errors" />
                @include('pedidos.formOrders')
            </div>
            <div class="card-footer">
                <td><button wire:click="update({{ $order['id'] }})" type="button"
                        class="btn btn-primary">Actualizar</button></td>
                <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>
    </div>
</div>

<x-modal-select-installation :installation="$installation" :searchRevisions="$searchRevisions" :revisions="$revisions" :showSelection='$showSelectionRevisions' />
