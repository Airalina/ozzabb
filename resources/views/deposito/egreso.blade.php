<div>
    <button wire:click="backToExplorar()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Egreso desde el depósito: {{ $warehouse['name'] }}</h3>
    </div>
    <form>
        <div class="card-body">
            <x-form-validation-errors :errors="$errors" />
            <h5>Datos de Egreso</h5>
            <div class="card-body">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Seleccione el destino:</h3>
                            <br>
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input wire:model="searchDeposit" type="text"
                                    class="form-control form-control-xs float-right" placeholder="Buscar depósito...">
                            </div>
                        </div>
                        <!--.card-body -->
                        @if ($searchDeposit != '')
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">ID</th>
                                            <th style="text-align: center">Nombre</th>
                                            <th style="text-align: center">Descripción</th>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($warehouses as $warehouse)
                                            <tr>
                                                <td style="text-align: center">{{ $warehouse->id }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $warehouse->name }}</td>
                                                <td style="text-align: center">
                                                    {{ $warehouse->description }}</td>
                                                <td style="text-align: center">
                                                    {{ $types[$warehouse->type] }}
                                                </td>
                                                <td style="text-align: center"><button type="button"
                                                        wire:click="selectDeposit({{ $warehouse->id }})"
                                                        class="btn btn-success btn-sm">Agregar</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="100%" class="py-3 italic">No hay
                                                    información
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @if (!empty($warehouseDestination))
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Depósito destino:</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">ID</th>
                                                <th style="text-align: center">Nombre</th>
                                                <th style="text-align: center">Descripción</th>
                                                <th style="text-align: center">Tipo</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center">{{ $warehouseDestination->id }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $warehouseDestination->name }}</td>
                                                <td style="text-align: center">
                                                    {{ $warehouseDestination->short_description }}</td>
                                                <td style="text-align: center">
                                                    {{ $types[$warehouseDestination->type] }}
                                                </td>
                                                <td style="text-align: center"><button type="button"
                                                        wire:click="downDeposit({{ $warehouseDestination->id }})"
                                                        class="btn btn-danger btn-sm">Quitar</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        @endif

                    </div>
                    <!-- /.card -->
                </div> <!-- col -->
                <x-form-moves-warehouses />
                @if ($warehouse['type'] == 1 || $warehouse['type'] == 2)
                    <br>
                    <div class="col">
                        <div class="form-group">
                            <label for="family">Seleccione el tipo de producto a ingresar:</label>
                            <select class="form-control form-control-sm col-3" wire:model="selection" id="selection">
                                <option value="" hidden>Selecciona un tipo de producto</option>
                                <option value="Materiales">Materiales</option>
                                <option value="Ensamblados">Ensamblados</option>
                            </select>
                        </div>
                        @if ($selection == 'Materiales')
                            <x-form-select-deposited type="material" searchType="searchMaterials" :products="$materials"
                                :productsSelected="$productsSelected" progress="egreso" />
                        @elseif($selection == 'Ensamblados')
                            <x-form-select-deposited type="ensamblado" searchType="searchAssembleds" :products="$assembleds"
                                :productsSelected="$productsSelected" progress="egreso" />
                        @endif
                    @elseif ($warehouse['type'] == 3)
                        <x-form-select-deposited type="ensamblado" searchType="searchAssembleds" :products="$assembleds"
                            :productsSelected="$productsSelected" progress="egreso" />
                    @elseif ($warehouse['type'] == 4)
                        <x-form-select-deposited type="instalacion" searchType="searchInstallations" :products="$installations"
                            :productsSelected="$productsSelected" progress="egreso" />

                @endif
            </div>
            <div class="card-footer">
                <td><button wire:click="storeMovements()" type="button" class="btn btn-primary">Guardar </button>
                </td>
                <td><button wire:click="backToExplorar()" type="button" class="btn btn-primary">Cancelar</button>
                </td>
            </div>
    </form>

    <div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form wire.submit.prevent="addmaterial">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Egreso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (!empty($productSelected))
                            <x-form-validation-errors :errors="$errors" />
                            <div class="form-group">
                                <p><label>Código: </label> {{ $productSelected['code'] }}</p>
                            </div>
                            <div class="form-group">
                                <p><label>Descripción: </label> {{ $productSelected['description'] }}</p>
                            </div>
                            @if ($selection == 'Materiales' && !empty($productSelected['presentation']))
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-2">
                                            <label>Packaging:</label>
                                        </div>
                                        <div class="col-3">
                                            <select wire:model.defer="product.packaging" id="packaging"
                                                class="form-control form-control-sm pl-2" wire:change="calculateAmountAvaiable">
                                                <option value="" hidden>Seleccione</option>
                                                @foreach ($productSelected['presentation'] as $presentation)
                                                    <option>{{ $presentation }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-2">
                                        <label>Cantidad disponible:</label>
                                    </div>
                                    <div class="col-3">
                                          <input
                                                wire:model.defer="amount.avaiable"
                                                type="number" class="form-control form-control-sm" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-2">
                                        <label>Cantidad:</label>
                                    </div>
                                    <div class="col-3">
                                        <input wire:model.defer="product.amount" type="number"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click.prevent="addProduct()"
                            class="btn btn-primary btn-sm">Agregar</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"
                            wire:click.prevent="backModal()">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
