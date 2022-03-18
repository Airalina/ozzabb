<div>
    <div>
        <button wire:click="backmat()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
            Volver</button>
    </div>
    <br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            @if($funcion=="crearmat")<h3 class="card-title">Agregar Precio</h3>@else<h3 class="card-title">Informacion
                sobre el precio: </h3>@endif

        </div>

        <div class="card-body">
            <h5>Datos del material</h5>
            <br>
            <x-form-validation-errors :errors="$errors" />
            <form method="post">
                <div class="col">
                    <div class="card mb-3 border-dark">
                        <div class="card-header">
                            @if($addProvider)
                            <div class="form-group">
                                <button wire:click="addProvider()" type="button" class="btn btn-info btn-sm">Agregar
                                    proveedor nuevo</button>
                            </div>
                            <h3 class="card-title">Seleccione proveedor a ser agregado:</h3>
                            <br>
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input wire:model="searchproviders" type="text"
                                    class="form-control form-control-xs float-right" placeholder="Buscar proveedor...">
                            </div>

                            @if ($searchproviders != '')
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Código</th>
                                            <th style="text-align: center">Nombre y Apellido</th>
                                            <th style="text-align: center">Email</th>
                                            <th style="text-align: center">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($providers)
                                        @forelse($providers as $provider)
                                        <tr>
                                            <td style="text-align: center">{{ $provider->id }}</td>
                                            <td style="text-align: center">{{ $provider->name }}</td>
                                            <td style="text-align: center">
                                                {{ $provider->email }}</td>
                                            <td style="text-align: center"><button type="button"
                                                    wire:click="selectprovider({{ $provider->id }})"
                                                    class="btn btn-success btn-sm">Agregar</button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="text-center">
                                            <td colspan="4" class="py-3 italic">No hay
                                                información
                                            </td>
                                        </tr>
                                        @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            @endif
                            @if(isset($provider_new))
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Proveedor agregado:</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Código</th>
                                                <th style="text-align: center">Nombre y Apellido</th>
                                                <th style="text-align: center">Email</th>
                                                <th style="text-align: center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center">{{ $provider_new->id }}</td>
                                                <td style="text-align: center">{{ $provider_new->name }}</td>
                                                <td style="text-align: center">{{ $provider_new->email }}</td>
                                                <td style="text-align: center"><button type="button"
                                                        wire:click="downprovider"
                                                        class="btn btn-danger btn-sm">Quitar</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="amount">Código de material</label>
                                <input class="form-control form-control-sm" type="string" id="provider_material_code"
                                    wire:model="provider_material_code" placeholder="Código del material interno del proveedor">
                            </div>
                            <div class="form-group">
                                <label for="amount">Cantidad</label>
                                <input class="form-control form-control-sm" type="string" id="amount"
                                    wire:model="amount" placeholder="Ingrese la cantidad">
                            </div>
                            <div class="form-group">
                                <label for="unit">Unidad de presentación</label>
                                <div class="d-flex">
                                    <input class="form-control form-control-sm" type="string" id="unit"
                                        wire:model="unit" placeholder="Ingrese las unidades">
                                    <select class="form-control form-control-sm" wire:model="presentation"
                                        id="presentation">
                                        <option selected value="">Selecciona una medida</option>
                                        <option value="m">Metros</option>
                                        <option value="und">Unidades</option>
                                        <option value="cajas">Cajas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usd_price">Precio U$D</label>
                                <input class="form-control form-control-sm" type="text" id="usd_price"
                                    wire:model="usd_price" placeholder="Ingrese el precio U$D">
                            </div>
                            <div class="form-group">
                                <label for="ars_price">Precio AR$</label>
                                <input class="form-control form-control-sm" type="text" id="ars_price"
                                    wire:model="ars_price" placeholder="Ingrese el precio AR$" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                @if(isset($provider_new))
                    @if($funcion=="crearmat")
                    <td><button wire:click="storemat({{ $material }})" type="button"
                            class="btn btn-primary">Guardar</button></td>

                    @else
                    <td><button wire:click="editarmat()" type="button" class="btn btn-primary">Guardar
                            Cambios</button></td>
                    @endif
                @endif
                    <td><button wire:click="backmat()" type="button" class="btn btn-primary">Cancelar</button></td>
                </div>
            </form>
        </div></div></div>
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
                                    wire:model.defer="name_provider" placeholder="Nombre de la empresa" required>
                            </div>
                            <div class="form-group">
                                <label for="addres_provider">Domicilio</label>
                                <input type="text" class="form-control form-control-sm" id="addres_provider"
                                    wire:model.defer="addres_provider" placeholder="Domicilio" required>
                            </div>
                            <div class="form-group">
                                <label for="email_provider">Correo electrónico para ventas</label>
                                <input type="email" class="form-control form-control-sm" id="email_provider"
                                    wire:model.defer="email_provider" placeholder="Correo electrónico para ventas"
                                    required>
                            </div>
                            <div class="modal-footer">
                                @if ($funcion == 'crearmat')
                                <button wire:click.prevent="addproviderprice()" type="submit"
                                    class="btn btn-primary">Guardar</button>
                                @else
                                <button wire:click.prevent="addproviderprice()" type="submit"
                                    class="btn btn-primary">Guardar
                                    Cambios</button>
                                @endif
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
</div>