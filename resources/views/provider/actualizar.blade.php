<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Informacion sobre el Proveedor:
                {{ $provider['name'] }}</h3>
        </div>
        <form>
            <div class="card-body">
                <x-form-validation-errors :errors="$errors" />
                <x-form-create-provider />
            </div>
            <div class="card-footer">
                <td><button wire:click="update({{ $provider['id'] }})" type="button" class="btn btn-primary">Guardar</button></td>
                <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>
        </form>
    </div>
