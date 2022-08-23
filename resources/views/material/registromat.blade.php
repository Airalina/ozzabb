<div>
    <div>
        <button wire:click="backToExplorar()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
            Volver
        </button>
    </div>
    <br>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Informacion sobre el precio: </h3>
            </div>
            <div class="card-body">
                <h5>Datos del precio</h5>
                <br>
                <x-form-validation-errors :errors="$errors" />
                <form method="post">
                    <x-form-provider-price :searchproviders="$searchproviders" :providers="$providers" :addprovider="$addProvider" :providerselected="$providerSelected" />
                    <div class="card-footer">
                        @if ($funcion == 'crearPrecio')
                            <td><button wire:click="storePrice({{ $material['id'] }})" type="button"
                                    class="btn btn-primary">Guardar</button></td>
                        @else
                            <td><button wire:click="updatePrice({{ $material['id'] }})" type="button" class="btn btn-primary">Actualizar
                                </button></td>
                        @endif
                        <td><button wire:click="backToExplorar()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-modal-provider-price />
</div>
