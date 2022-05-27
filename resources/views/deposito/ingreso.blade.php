<div>
    <button wire:click="toexplora()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Ingreso a deposito: {{$name}}</h3>
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
            <h5>Datos de Ingreso</h5>
            <div class="card-body">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Seleccione el origen:</h3>
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
                        @if (!empty($depo))
                        @if($depo_id != 0)
                        <div class="card">
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
                                                    wire:click="downdeposit({{ $depo->id }})"
                                                    class="btn btn-danger btn-sm">Quitar</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        @endif
                        @endif

                    </div>
                    <!-- /.card -->
                </div> <!-- col -->
                <div class="form-group">
                    <label for="exampleInputEmail1">Responsable de ingreso:</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="text" wire:model="name_entry" class="form-control form-control-sm"
                                style="width: auto" placeholder="Responsable de ingreso">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Responsable de recibir:</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="text" wire:model="name_receive" class="form-control form-control-sm"
                                style="width: auto" placeholder="Responsable de recibir">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Fecha</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="date" wire:model="date" class="form-control form-control-sm"
                                style="width: auto" placeholder="dd/mm/AAAA">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Hora</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="time" wire:model="hour" style="width: auto"
                                class="form-control form-control-sm" placeholder="">
                        </div>
                    </div>
                </div>
                @if($type==1||$type==2)

                <br>
                <div class="col">
                    <div class="form-group">
                        <label for="family">Seleccione el tipo de producto a ingresar:</label>
                        <select class="form-control form-control-sm col-3" wire:model="selection" id="selection" {{
                            $disabled }}>
                            <option value="">Selecciona un tipo de producto</option>
                            <option value="Materiales">Materiales</option>
                            <option value="Ensamblados">Ensamblados</option>
                        </select>
                    </div>
                    @if ($selection == 'Materiales')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Seleccione material a ser agregado:</h3>
                            <br>
                            <div class="input-group input-group-sm" style="width: 150px;">

                                <input wire:model="searchmaterialsdepo" type="text"
                                    class="form-control form-control-xs float-right" placeholder="Buscar material...">

                            </div>
                        </div>
                        <!-- /.card-header -->
                        @if($searchmaterialsdepo!="")
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">Codigo</th>
                                        <th style="text-align: center">Descripción</th>
                                        <th style="text-align: center">Familia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($materials_deposits as $material_deposit)
                                    <tr>
                                        <td style="text-align: center">{{ $material_deposit->code }}</td>
                                        <td style="text-align: center">{{ $material_deposit->description }}</td>
                                        <td style="text-align: center">{{ $material_deposit->family }}</td>
                                        <td><button type="button"
                                                wire:click="selectmaterial({{ $material_deposit->id }})"
                                                class="btn btn-success btn-sm">Seleccionar</button></td>
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
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Materiales agregados:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">Codigo</th>
                                        <th style="text-align: center">Descripción</th>
                                        <th style="text-align: center">Packaging</th>
                                        <th style="text-align: center">Cantidad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($details as $detail)
                                    <tr>
                                        <td style="text-align: center">{{ $detail[0] }}</td>
                                        <td style="text-align: center">{{ $detail[1] }}</td>
                                        <td style="text-align: center">{{ $detail[5] }}</td>
                                        <td style="text-align: center">{{ $detail[2] }}</td>
                                        <td style="text-align: center"><button type="button"
                                                wire:click="downmateriald({{ $detail[3] }})"
                                                class="btn btn-danger btn-sm">Quitar</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    @elseif($selection == 'Ensamblados')
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <button wire:click="createassembled()" type="button" float="right"
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
                                        <td><button type="button" wire:click="addassembled({{ $ensamble->id }})"
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
                        @if($select==true)
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
                                    <tr>
                                        <td style="text-align: center">{{ $material_id }}</td>
                                        <td style="text-align: center">{{ $description }}</td>
                                        <td style="text-align: center">{{ $amount }} </td>
                                        <td><button type="button" wire:click="downmaterial()"
                                                class="btn btn-danger btn-xs">Quitar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    @endif
                    @endif
                    @if($type==3)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <button wire:click="createassembled()" type="button" float="right"
                                    class="btn btn-info btn-sm">Agregar Ensamblado</button>
                            </div>
                            <h3 class="card-title">Seleccione ensamblado a ser agregado:</h3>
                            <br>
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input wire:model="searchensamblados" type="text"
                                    class="form-control form-control-xs float-right"
                                    placeholder="Buscar instalación...">
                            </div>
                        </div>
                        <!-- /.card-header -->
                        @if($searchensamblados!="" && $type==3 )
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
                                        <td><button type="button" wire:click="addassembled({{ $ensamble->id }})"
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
                        @if($select==true && $type==3)
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
                                    <tr>
                                        <td style="text-align: center">{{ $material_id }}</td>
                                        <td style="text-align: center">{{ $description }}</td>
                                        <td style="text-align: center">{{ $amount }} </td>
                                        <td><button type="button" wire:click="downmaterial()"
                                                class="btn btn-danger btn-xs">Quitar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @endif
                        @if($type==4)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Seleccione instalacion a ser agregada:</h3>
                                <br>
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input wire:model="searchinstallation" type="text"
                                        class="form-control form-control-xs float-right"
                                        placeholder="Buscar instalación...">
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- /.card-header -->
                                @if($searchinstallation!="" && $select==false && $seleccion="Instalacion" )
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
                                                <td><button type="button"
                                                        wire:click="addinstallation({{ $instalacion->id }})"
                                                        class="btn btn-success btn-xs">Agregar</button></td>
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
                                @if($select==true && $seleccion="Instalacion")
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
                                            <tr>
                                                <td style="text-align: center">{{ $code }}</td>
                                                <td style="text-align: center">{{ $description }}</td>
                                                <td><button type="button" wire:click="downinstallation()"
                                                        class="btn btn-danger btn-xs">Quitar</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>N° de revisión</th>
                                                <th>Razón</th>
                                                <th>Fecha de creación</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($revisiones as $rev)
                                            <tr>
                                                <td>{{ $rev->number_version }}</td>
                                                <td>{{ $rev->reason }}</td>
                                                <td>{{ date('d-m-Y', strtotime($rev->create_date)) }}</td>
                                                <td>
                                                    @if($revi==false)
                                                    <button type="button" wire:click="selectrevision({{$rev}})"
                                                        class="btn btn-primary btn-xs"> Seleccionar</button>
                                                    @else
                                                    <button type="button" wire:click="downrevision()"
                                                        class="btn btn-danger btn-xs"> Quitar</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="exampleInputEmail1">N° de serie: </label>
                                            <input type="text" wire:model="serial_number"
                                                class="form-control form-control-sm" style="width: auto"
                                                placeholder="Ingrese N° de serie">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">N° de pedido de cliente: </label>
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="number" wire:model="client_order_id"
                                                class="form-control form-control-sm" style="width: auto"
                                                placeholder="Ingrese N° de orden de cliente">
                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endif
                                @if($seleccion=="Orden de ingreso de materiales")
                                <div class="form-group">
                                    <label for="exampleInputEmail1">N° de orden de ingreso: </label>
                                    <input type="number" wire:model="entry_order_id"
                                        class="form-control form-control-sm"
                                        placeholder="Ingrese N° deorden de ingreso">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">N° de orden compra: </label>
                                    <input type="number" wire:model="buy_order_id" class="form-control form-control-sm"
                                        placeholder="Ingrese N° de orden de compra">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">N° de remito: </label>
                                    <input type="text" wire:model="follow_number" class="form-control form-control-sm"
                                        placeholder="Ingrese N° de remito">
                                </div>


                            </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button>
                            </td>
                            <td><button wire:click="toexplora()" type="button" class="btn btn-primary">Cancelar</button>
                            </td>
                        </div>
    </form>

    <div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form wire.submit.prevent="addmaterial">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">Ingreso material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>    
                    </div>
                    <div class="modal-body">
                    @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif
                        @if($type==3 || $selection != 'Materiales')
                        <div class="form-group">
                            <p><label>Codigo: </label> {{$material_id}}</p>
                        </div>
                        <div class="form-group">
                            <p><label>Descripción: </label> {{$description}}</p>
                        </div>
                        <div class="form-group">
                            <label>Cantidad:</label>
                            <input wire:model.defer="amount" type="number">
                        </div>
                        @else
                        <div class="form-group">
                            <p><label>Codigo: </label> {{$codem}}</p>
                        </div>
                        <div class="form-group">
                            <p><label>Descripción: </label> {{$descriptionm}}</p>
                        </div>
                        @if(!empty($presentationm))
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label>Packaging:</label>
                                </div>
                                <div class="col-4">
                                    <select wire:model.defer="presentation" id="presentation"
                                        class="form-control form-control-sm">
                                        <option selected>Seleccione un packaging</option>
                                        @foreach ($presentationm as $presentation)
                                        <option value="{{ $presentation->presentation }}"> {{
                                            $presentation->presentation }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @else      
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label>Packaging: </label>
                                </div>
                                <div class="col-4">
                                    <input wire:model.defer="presentation" type="number">
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label>Cantidad: </label>
                                </div>
                                <div class="col-4">
                                    <input wire:model.defer="amount" type="number">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if($type==3 || $selection != 'Materiales')
                        <button type="submit" wire:click.prevent="addassembledd()"
                            class="btn btn-primary btn-sm">Agregar</button>
                        @else
                        <button type="submit" wire:click.prevent="addmateriald()"
                            class="btn btn-primary btn-sm">Agregar</button>
                        @endif
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>