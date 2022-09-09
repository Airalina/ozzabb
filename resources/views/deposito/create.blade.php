<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registro de depósito</h3>
        </div>
        <form>
            <div class="card-body">
                <x-form-validation-errors :errors="$errors" />
                <h5>Datos de depósito</h5>
                <br>
                <x-form-create-warehouse :types="$types" showOptions="1" />
            </div>
            <div class="card-footer">
                <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>
        </form>
    </div>
</div>
