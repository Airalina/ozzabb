<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div><br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Órden de trabajo: {{ $workorder->code }}</h3>

    </div>
    <!-- /.card-header -->
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
            <div class="d-flex justify-content-between">
                <div class="pl-2">
                    <h5>Cancelar pedido: {{ $orden_id }}/{{ date('Y', strtotime($orden_date))}} </h5>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="selection">Seleccione el producto a ingresar:</label>
                    <select class="form-control form-control-sm col-3" wire:model="selection" id="selection"
                        >
                        <option value="" hidden="">Selecciona un tipo de producto</option>
                        <option value="Instalaciones">Instalaciones</option>
                        <option value="Ensamblados">Ensamblados</option>
                    </select>
                </div>
            </div>

            @if ($selection == 'Instalaciones')
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Seleccione el depósito de instalaciones para almacenar:</h3>
                        <br>
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="searchdeposito" type="text"
                                class="form-control form-control-xs float-right" placeholder="Buscar depósito...">
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
                                            wire:click="selectdeposit({{ $deposit->id }})"
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
                    @if (!empty($depo_instalacion))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Depósito seleccionado:</h3>
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
                                        <td style="text-align: center">{{ $depo_instalacion_id }}
                                        </td>
                                        <td style="text-align: center">
                                            {{ $depo_instalacion_name }}</td>
                                        <td style="text-align: center">
                                            {{ $depo_instalacion_description }}</td>
                                        <td style="text-align: center">
                                            @if($depo_instalacion_type==1)
                                            Almacen
                                            @elseif($depo_instalacion_type==2)
                                            Producción
                                            @elseif($depo_instalacion_type==3)
                                            Ensamblados
                                            @elseif($depo_instalacion_type==4)
                                            Expedición
                                            @endif
                                        </td>
                                        <td style="text-align: center"><button type="button"
                                                wire:click="downdeposit({{ $depo_instalacion_id }})"
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
            <div class="card card-tabs">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <button wire:click="createproduct()" type="button" float="right"
                                class="btn btn-info btn-sm">Agregar Instalación</button>
                        </div>
                        <h3 class="card-title">Seleccione instalación a ser agregada:</h3>
                        <br>
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="searchinstalaciones" type="text"
                                class="form-control form-control-xs float-right" placeholder="Buscar instalación...">
                        </div>
                    </div>
                    @if($searchinstalaciones!="")
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Descripción</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($instalaciones as $instalacion)
                                <tr>
                                    <td style="text-align: center">{{ $instalacion->code }}</td>
                                    <td style="text-align: center">{{ $instalacion->description }}</td>
                                    <td><button type="button" wire:click="selectproduct({{ $instalacion->id }})"
                                            class="btn btn-success btn-sm">Agregar</button></td>
                                </tr>
                                @empty
                                <tr class="text-center">
                                    <td colspan="4" class="py-3 italic">No hay información</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(!empty($installations))
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Descripción</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($installations as $index => $installation)
                                <tr>
                                    <td style="text-align: center">{{ $installation[1] }}</td>
                                    <td style="text-align: center">{{ $installation[2] }}</td>
                                    <td style="text-align: center"><button type="button"
                                            wire:click="downproduct({{ $installation[0] }})"
                                            class="btn btn-danger btn-sm">Quitar</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @endif


                </div>
            </div>
            @elseif($selection == 'Ensamblados')
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Seleccione el depósito de ensamblados para almacenar:</h3>
                        <br>
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="searchdeposito" type="text"
                                class="form-control form-control-xs float-right" placeholder="Buscar depósito...">
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
                                            wire:click="selectdeposit({{ $deposit->id }})"
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
                    @if (!empty($depo_ensamblado))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Depósito seleccionado:</h3>
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
                                        <td style="text-align: center">{{ $depo_ensamblado_id }}
                                        </td>
                                        <td style="text-align: center">
                                            {{ $depo_ensamblado_name }}</td>
                                        <td style="text-align: center">
                                            {{ $depo_ensamblado_description }}</td>
                                        <td style="text-align: center">
                                            @if($depo_ensamblado_type==1)
                                            Almacen
                                            @elseif($depo_ensamblado_type==2)
                                            Producción
                                            @elseif($depo_ensamblado_type==3)
                                            Ensamblados
                                            @elseif($depo_ensamblado_type==4)
                                            Expedición
                                            @endif
                                        </td>
                                        <td style="text-align: center"><button type="button"
                                                wire:click="downdeposit({{ $depo_ensamblado_id }})"
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
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <button wire:click="createproduct()" type="button" float="right"
                            class="btn btn-info btn-sm">Agregar Ensamblado</button>
                    </div>
                    <h3 class="card-title">Seleccione ensamblado a ser agregado:</h3>
                    <br>
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input wire:model="searchensamblados" type="text"
                            class="form-control form-control-xs float-right" placeholder="Buscar ensamblado...">
                    </div>
                </div>
                @if($searchensamblados!="")
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Descripción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ensamblados as $ensamble)
                            <tr>
                                <td style="text-align: center">{{ $ensamble->id }}</td>
                                <td style="text-align: center">{{ $ensamble->description }}</td>
                                <td><button type="button" wire:click="selectproduct({{ $ensamble->id }})"
                                        class="btn btn-success btn-sm">Agregar</button></td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="4" class="py-3 italic">No hay información</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif
                @if(!empty($assembleds))
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assembleds as $index => $assembled)
                            <tr>
                                <td style="text-align: center">{{ $assembled[0] }}</td>
                                <td style="text-align: center">{{ $assembled[1] }}</td>
                                <td style="text-align: center">{{ $assembled[2] }}</td>
                                <td style="text-align: center"><button type="button"
                                        wire:click="downproduct({{ $assembled[0] }})"
                                        class="btn btn-danger btn-sm">Quitar</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @endif


            </div>
            @endif
            <div class="card-footer">
                <td><button wire:click="store_cancelar()" type="button" class="btn btn-primary">Guardar </button></td>
                <td><button wire:click="backexpl()" type="button" class="btn btn-primary">Cancelar</button></td>
            </div>

            <div wire:ignore.self class="modal" id="form-product" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form wire.submit.prevent="product">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ ($selection == 'Ensamblados') ? 'Ensamblados' :
                                    'Instalaciones' }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <p><label>Código: </label> {{ ($selection == 'Ensamblados') ? $assembled_id :
                                        $installation_code }}</p>
                                </div>
                                <div class="form-group">
                                    <p><label>Descripción: </label> {{ ($selection == 'Ensamblados') ?
                                        $assembled_description : $installation_description }}</p>
                                </div>
                                @if ($selection == 'Ensamblados')
                                <div class="form-group">
                                    <label>Cantidad:</label>
                                    <input wire:model.defer="amount" type="number">
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="submit" wire:click.prevent="addproduct()"
                                    class="btn btn-primary btn-sm">Agregar</button>
                                <button type="button" class="btn btn-danger btn-sm" wire:click.prevent="backcancel()"
                                    data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </form>

</div>