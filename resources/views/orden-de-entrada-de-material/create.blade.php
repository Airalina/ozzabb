<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Registro orden de ingreso de materiales</h3>
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
            <h5>Datos de orden de ingreso de materiales</h5>
            <br>
            <div class="card-body">

                <select class="form-control select2 select2-hidden-accessible" wire:model="modo"
                    wire:change="modo_select" style="width: auto;">
                    <option selected="selected">Seleccione un modo</option>
                    <option>Sin orden de compra</option>
                    <option>Con orden de compra</option>
                </select>
                <br>
                <div class="form-group">
                    @if ($campos_modo == 'Sin orden de compra')
                        <div class="form-group">
                            <label>Origen</label>
                            <input class="form-control form-control-sm" type="text" wire:model="origen"
                                style="width: 300px;" placeholder="Ingrese origen del material a ser ingresado">
                        </div>
                        <div class="form-group">
                            <label>Causa</label>
                            <input class="form-control form-control-sm" type="text" wire:model="causa"
                                style="width: 300px;" placeholder="Ingrese causa por la cual ingresa los materiales">
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
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Seleccione material a ser agregado:</h3>
                                    <br>
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input wire:model="searchmateriales" type="text"
                                            class="form-control form-control-xs float-right"
                                            placeholder="Buscar material...">
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                @if ($searchmateriales != '')
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">Codigo</th>
                                                    <th style="text-align: center">Descripción</th>
                                                    <th style="text-align: center">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($materiales as $material)
                                                    <tr>
                                                        <td style="text-align: center">{{ $material->code }}
                                                        </td>
                                                        <td style="text-align: center">
                                                            {{ $material->description }}</td>
                                                        <td style="text-align: center"><button type="button"
                                                                wire:click="selectmaterial({{ $material->id }})"
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
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col">
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
                                                <th style="text-align: center">Presentación</th>
                                                <th style="text-align: center">Cantidad</th>
                                                <th style="text-align: center">Deposito Id</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($details as $detail)
                                                <tr>
                                                    <td style="text-align: center">{{ $detail[0] }}</td>
                                                    <td style="text-align: center">{{ $detail[1] }}</td>
                                                    <td style="text-align: center">{{ $detail[5] }}</td>
                                                    <td style="text-align: center">{{ $detail[2] }}</td>
                                                    <td style="text-align: center">{{ $detail[6] }}</td>
                                                    <td style="text-align: center"><button type="button"
                                                            wire:click="downmaterial({{ $detail[3] }})"
                                                            class="btn btn-danger btn-sm">-</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        @elseif($campos_modo=="Con orden de compra")
                            <div class="form-group">
                                <label>N° de remito:</label>
                                <input class="form-control form-control-sm" type="text" wire:model="follow"
                                    style="width: 300px;" placeholder="Ingrese N° remito">
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
                            <div class="card">
                                @if ($ingresa == false)
                                    <div class="card-header">
                                        <h3 class="card-title">Seleccione orden de compra:</h3>
                                        <br />
                                        <div wire:ignore class="input-group input-group-sm" style="width: 130px">
                                            <input wire:model="searchorderbuy" type="text"
                                                class="form-control form-control-xs float-right"
                                                placeholder="Buscar orden..." />
                                        </div>
                                    </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" wire:model="close_order" class="form-check-input"
                                    id="exampleCheck1" checked="" class="form-control">
                                <label for="exampleCheck1">Cerrar orden</label>
                            </div>
                            @if ($searchorderbuy != '')
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Código</th>
                                                <th style="text-align: center">Nombre del proveedor</th>
                                                <th style="text-align: center">Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($buyorders as $ord => $order)
                                                <tr>
                                                    <td style="text-align: center">#{{ $order->id }}/2021
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{ $order->provider->name }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{ $order->buy_date->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <button type="button"
                                                                wire:click="addorder({{ $order->id }})"
                                                                class="btn btn-success btn-xs">
                                                                Agregar
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="text-center">
                                                    <td colspan="4" class="py-3 italic">No hay información
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <!-- /.card-body -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Detalle de orden de ingreso</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Código Material</th>
                                                <th style="text-align: center">Descripción</th>
                                                <th style="text-align: center">Presentación</th>
                                                <th style="text-align: center">Cantidad pedida</th>
                                                <th style="text-align: center">Cantidad enviada</th>
                                                <th style="text-align: center">Cantidad remito</th>
                                                <th style="text-align: center">Diferencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    @endif

                    @if (isset($buyorderinfo))

                        @forelse($buyorderinfo as $nro => $buyorder)

                            <tr>
                                <td style="text-align: center">
                                    {{ $buyorder->material->code }}
                                </td>
                                <td style="text-align: center">
                                    {{ $buyorder->material->description }}</td>

                                <td style="text-align: center">
                                    {{ $buyorder->presentation }}
                                </td>
                                <td style="text-align: center">
                                    {{ $buyorder->amount }}</td>
                                <td style="text-align: center">
                                    <div wire:ignore>
                                        <input class="form-control form-control-sm" type="text"
                                            wire:model="received_amount.{{ $buyorder->material_id }}"
                                            wire:change="amount_change({{ $buyorder->id }})" placeholder="Cantidad"
                                            required>
                                    </div>
                                </td>
                                <td style="text-align: center">
                                    <div wire:ignore>
                                        <input class="form-control form-control-sm" type="text"
                                            wire:model="refer_amount.{{ $buyorder->material_id }}"
                                            wire:change="amount_change({{ $buyorder->id }})" placeholder="Cantidad"
                                            required>
                                    </div>
                                </td>
                                <td style="text-align: center">
                                    @if (isset($difference[$buyorder->material_id]))
                                        {{ $difference[$buyorder->material_id] }}
                                    @else

                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td style="text-align: center" colspan="4" class="py-3 italic">No
                                    hay
                                    información</td>
                            </tr>
                        @endforelse
                    @endif

                    </tbody>
                    </table>

                </div>
                <!-- /.card-body -->

            @elseif($ingresa==true)
                <div class="card-header">
                    <h3 class="card-title">Detalle de orden de entrada: {{ $entry_order_id }}
                    </h3>
                </div>
                <div class="card-body table-responsive  p-0">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th style="text-align: center">Código Material</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-aling: center">N° Deposito</th>
                                <th style="text-align: center">Presentación</th>
                                <th style="text-align: center">Cantidad requerida</th>
                                <th style="text-align: center">Cantidad remito</th>
                                <th style="text-align: center">Cantidad recibida</th>
                                <th style="text-align: center">Diferencia</th>
                                <th style="text-align: center">Sin Entrgar</th>
                                <th style="text-align: center">Lote</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">{{ $code }}</td>
                                <td style="text-align: center">{{ $description }}</td>
                                <td style="text-align: center">
                                    <select class="form-control select2 select2-hidden-accessible"
                                        wire:model="nombre_deposito" style="width: 100%;">
                                        <option selected="selected"></option>
                                        @foreach ($depositos as $deposito)
                                            <option>{{ $deposito->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="text-align: center">{{ $presentation }}</td>
                                <td style="text-align: center">{{ $amount_requested }}</td>
                                <td style="text-align: center"><input style="width: 100px" wire:model="amount_follow"
                                        type="number"></td>
                                <td style="text-align: center"><input style="width: 100px" wire:model="amount"
                                        type="number"></td>
                                <td style="text-align: center">{{ $amount_requested - $amount }}
                                </td>
                                <td style="text-align: center"><input style="width: 100px"
                                        wire:model="amount_undelivered" type="number"></td>
                                <td style="text-align: center"><input style="width: 100px" wire:model="set" type="text">
                                </td>
                                <td style="text-align: center"><button type="button"
                                        wire:click="addmaterial({{ $material_id }})" class="btn btn-success btn-sm">
                                        Ingresar</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                @endif
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
                        <h5 class="modal-title">Material seleccionado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <p><label>Codigo: </label> {{ $code_m }}</p>
                            </div>
                            <div class="form-group">
                                <p><label>Descripción: </label> {{ $description_m }}</p>
                            </div>
                            <div class="form-group">
                                <label>Presentación:</label>
                                <input wire:model.defer="present" type="number">
                            </div>
                            <div class="form-group">
                                <label>Cantidad:</label>
                                <input wire:model.defer="cant" type="number">
                            </div>
                            <div class="form-group">
                                <label>Deposito:</label>
                                <select class="form-control select2 select2-hidden-accessible"
                                    wire:model="nombre_deposito" style="width: 100%;">
                                    <option selected="selected"></option>
                                    @foreach ($depositos as $deposito)
                                        <option>{{ $deposito->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <div class="modal-footer">
                            <button type="submit" wire:click.prevent="addmaterial({{ $id_m }})"
                                class="btn btn-primary btn-sm">Agregar</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
