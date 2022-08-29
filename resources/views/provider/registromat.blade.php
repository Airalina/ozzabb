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
                <form>
                    <x-form-material-price :searchmaterials="$searchmaterials" :materials="$materials" :addMaterial="$addMaterial" :materialSelected="$materialSelected" />
                    <div class="card-footer">
                        @if ($view == 'crearPrecio')
                            <td><button wire:click="storePrice({{ $provider['id'] }})" type="button" class="btn btn-primary">Guardar</button>
                            </td>
                        @else
                            <td><button wire:click="updatePrice({{ $provider['id'] }})" type="button" class="btn btn-primary">Guardar
                                    Cambios</button>
                            </td>
                        @endif

                        <td><button wire:click="backToExplorar()" type="button" class="btn btn-primary">Cancelar</button>
                        </td>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-modal-material-price :familySelected="$familySelected" :materialContent="$materialContent" :searchTerminal="$searchTerminal" :searchSeal="$searchSeal" :information="$information"
    />
</div>
