<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Registro orden de egreso de materiales</h3>
    </div>
    <form>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h5>Datos de orden de egreso de materiales</h5>
            <br>
            <div class="card-body">
                <!--
                <div class="form-group">
                    <label>Tipo de orden de egreso</label>
                    <select class="form-control select2 select2-hidden-accessible" wire:model="modo"
                        style="width: auto;">
                        <option selected="selected">Seleccione un modo</option>
                        <option>Sin pedido</option>
                        <option>Con pedido</option>
                    </select>
                </div>
                -->
                <br>
                <div class="form-group">
                    @if ($modo == 'Sin pedido')
                    <div class="col">
                        <div class="form-group">
                            <label for="family">Seleccione el tipo de producto a egresar:</label>
                            <select class="form-control form-control-sm col-3" wire:model="selection" id="selection">
                                <option value="">Selecciona un tipo de producto</option>
                                <option value="Materiales">Materiales</option>
                                <option value="Ensamblados">Ensamblados</option>
                                <option value="Instalaciones">Instalaciones</option>
                            </select>
                        </div>
                        @if (!empty($selection))
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Seleccione {{ $product }} para agregar:</h3>
                                <br>
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input wire:model="search{{ $product }}" type="text"
                                        class="form-control form-control-xs float-right"
                                        placeholder="Buscar {{ $product }}...">
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Código</th>
                                            <th style="text-align: center">Descripción</th>
                                            <th style="text-align: center">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $productsearch)
                                        <tr>
                                            <td style="text-align: center">{{ isset($productsearch->code) ?
                                                $productsearch->code : $productsearch->id }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $productsearch->description }}</td>
                                            <td style="text-align: center"><button type="button"
                                                    wire:click="select{{ $product }}({{ $productsearch->id }})"
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
                                    </tbody>
                                </table>
                                
                            </div>
                            <!-- /.card-body -->
                        </div>
                        @endif
                        <!-- /.card -->
                    </div>
                    @elseif($modo=="Con pedido")


                    @endif
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Productos agregados:</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Producto</th>
                                            <th style="text-align: center">Codigo</th>
                                            <th style="text-align: center">Descripción</th>
                                            <th style="text-align: center">Presentación</th>
                                            <th style="text-align: center">Cantidad</th>
                                            <th style="text-align: center">Deposito</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($details as $type => $product_type)
                                        @foreach ($product_type as $prod)
                                        <tr>
                                            <td style="text-align: center">{{ $prod['type'] }}</td>
                                            <td style="text-align: center">{{ $prod['code'] }}</td>
                                            <td style="text-align: center">{{ $prod['description'] }}</td>
                                            <td style="text-align: center">{{ $prod['presentation'] }}</td>
                                            <td style="text-align: center">{{ $prod['amount'] }}</td>
                                            <td style="text-align: center">{{ $prod['warehouse_name'] }}</td>
                                            <td style="text-align: center"><button type="button"
                                                    wire:click="downproduct({{ $prod['id'] }}, '{{ $type }}', {{ $prod['amount'] }})"
                                                    class="btn btn-danger btn-sm">-</button></td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        <div class="form-group">
                            <label>Destino</label>
                            <input class="form-control form-control-sm" type="text" wire:model="destination"
                                style="width: 300px;" placeholder="Ingrese el destino">
                        </div>
                        <div class="form-group">
                            <label>Responsable del retiro</label>
                            <input class="form-control form-control-sm" type="text" wire:model="responsible"
                                style="width: 300px;" placeholder="Ingrese el responsable del retiro">
                        </div>
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" wire:model="date" class="form-control form-control-sm"
                                style="width: auto" placeholder="dd/mm/AAAA">
                        </div>
                        <div class="form-group">
                            <label>Hora</label>
                            <input type="time" wire:model="hour" class="form-control form-control-sm"
                                style="width: auto" placeholder="">
                        </div>

                        <!-- /.card -->

                    </div>

                    <div class="card-footer">
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button>
                        </td>
                        <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button>
                        </td>
                    </div>
    </form>
    <div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form wire.submit.prevent="addmaterial">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Producto seleccionado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <p><label>Tipo: </label> {{ $product }}</p>
                        </div>
                        <div class="form-group">
                            <p><label>Código: </label> {{ $code_m }}</p>
                        </div>
                        <div class="form-group">
                            <p><label>Descripción: </label> {{ $description_m }}</p>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Seleccione el origen:</h3>
                                <br>
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input wire:model="searchdeposito" type="text"
                                        class="form-control form-control-xs float-right"
                                        placeholder="Buscar depósito...">
                                </div>
                            </div>
                            <!--.card-body -->
                            @if ($searchdeposito != '')
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">id</th>
                                            <th style="text-align: center">Nombre</th>
                                            <th style="text-align: center">Descripción</th>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($deposits as $deposit)
                                        <tr>
                                            <td style="text-align: center">{{ $deposit->id }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $deposit->name }}</td>
                                            <td style="text-align: center">
                                                {{ $deposit->description }}</td>
                                            <td style="text-align: center">
                                                @if($deposit->type==1)
                                                Almacen
                                                @elseif($deposit->type==2)
                                                Producción
                                                @elseif($deposit->type==3)
                                                Ensamblados
                                                @elseif($deposit->type==4)
                                                Expedición
                                                @endif
                                            </td>
                                            <td style="text-align: center"><button type="button"
                                                    wire:click.prevent="selectdeposit({{ $deposit->id }})"
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
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            @if (!empty($depo))
                            <div class="card-header">
                                <h3 class="card-title">Depósito origen:</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">id</th>
                                            <th style="text-align: center">Nombre</th>
                                            <th style="text-align: center">Descripción</th>
                                            <th style="text-align: center">Tipo</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center">{{ $depo->id }}
                                            </td>
                                            <td style="text-align: center">
                                                {{ $depo->name }}</td>
                                            <td style="text-align: center">
                                                {{ $depo->description }}</td>
                                            <td style="text-align: center">
                                                @if($depo->type==1)
                                                Almacen
                                                @elseif($depo->type==2)
                                                Producción
                                                @elseif($depo->type==3)
                                                Ensamblados
                                                @elseif($depo->type==4)
                                                Expedición
                                                @endif
                                            </td>
                                            <td style="text-align: center"><button type="button"
                                                    wire:click.prevent="downdeposit({{ $depo->id }})"
                                                    class="btn btn-danger btn-sm">Quitar</button></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->
                            @endif

                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if ($selection == 'Materiales')
                        @if(!empty($presentations))
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label>Presentación:</label>
                                </div>
                                <div class="col-6">
                                    <select wire:model.defer="presentation_m" id="presentation_m"
                                        class="form-control form-control-sm" wire:click.prevent="change_amount()">
                                        <option selected>Seleccione una presentación</option>
                                        @foreach ($presentations as $presentation)
                                        <option> {{
                                            $presentation }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <p><label>Cantidad disponible: </label> {{ (!empty($amounts[$presentation_m])) ?
                                $amounts[$presentation_m] : '' }}</p>
                        </div>
                        @elseif ($selection == 'Ensamblados' || $selection == 'Instalaciones')
                        <div class="form-group">
                            <p><label>Cantidad disponible: </label> {{ (!empty($amounts[1])) ?
                                $amounts[1] : '' }}</p>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Cantidad:</label>
                            <input wire:model.defer="amount" type="number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click.prevent="addproduct()"
                            class="btn btn-primary btn-sm">Agregar</button>
                        <button type="button" wire:click.prevent="backmodal()" class="btn btn-danger btn-sm"
                            data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>