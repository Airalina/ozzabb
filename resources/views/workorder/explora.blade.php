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
                    <h5>Datos de orden de trabajo</h5>
                </div>
                <div class="pr-5">
                    <button type="button" wire:click="change_state({{ $workorder->id }}, 'Actual')"
                        class="btn btn-success btn-sm" {{ $disabled }}>
                        Enviar a la línea de producción
                    </button>
                    @if ($workorder->state == 'Actual')
                    <button type="button" wire:click="change_state({{ $workorder->id }}, 'Finalizada')"
                        class="btn btn-danger btn-sm">
                        Finalizar
                    </button>
                    @elseif ($workorder->state == 'Actual con pedidos cancelados')
                    <button type="button"
                        wire:click="change_state({{ $workorder->id }}, 'Finalizada con pedidos cancelados')"
                        class="btn btn-danger btn-sm">
                        Finalizar
                    </button>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Código</label>
                    <div class="row">
                        <div class="col-2">
                            <input class="form-control form-control-sm" type="text" wire:model="code"
                                placeholder="Código de orden" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fecha de Inicio</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="date" wire:model="start_date" class="form-control form-control-sm"
                                style="width: auto;" placeholder="dd/mm/AAAA" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fecha de Finalización</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="date" wire:model="end_date" class="form-control form-control-sm"
                                style="width: auto;" placeholder="dd/mm/AAAA" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Horas de trabajo disponibles</label>
                    <div class="row">
                        <div class="col-3">
                            <input class="form-control form-control-sm" type="text" wire:model="hours"
                                placeholder="Horas de trabajo disponibles" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Cantidad de empleados disponibles</label>
                    <div class="row">
                        <div class="col-3">
                            <input class="form-control form-control-sm" type="text" wire:model="man"
                                placeholder="Cantidad de empleados disponibles" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Cantidad de horas/hombres disponibles</label>
                    <div class="row">
                        <div class="col-3">
                            <input class="form-control form-control-sm" type="text" wire:model="hours_man_avaiable"
                                placeholder="Cantidad de horas/hombres disponibles" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Cantidad de horas/hombres necesarias</label>
                    <div class="row">
                        <div class="col-3">
                            <input class="form-control form-control-sm" type="text" wire:model="hours_man"
                                placeholder="Seleccione pedidos" disabled>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
            </div>
            <div class="card card-tabs">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body table-responsive">
                    <form>
                        <div class="card-header">
                            <h3 class="card-title">Pedidos de clientes en orden de trabajo:</h3>
                            <br>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">Código</th>
                                        <th style="text-align: center">Nombre del cliente</th>
                                        <th style="text-align: center">Fecha estimada de entrega</th>
                                        <th style="text-align: center">Estado</th>
                                        <th style="text-align: center">Fecha de pedido</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ordenes as $orden)
                                    <tr>
                                        <td style="text-align: center">{{ $orden['id'] }}/{{ date('Y',
                                            strtotime($orden['date']))}}</td>
                                        <td style="text-align: center">{{ $orden['customer_name'] }}</td>
                                        <td style="text-align: center">{{ date('d/m/Y', strtotime($orden['date']))}}
                                        </td>
                                        @switch($orden['order_state'])
                                        @case(1)
                                        <td style="text-align: center">Nuevo</td>
                                        @break
                                        @case(2)
                                        <td style="text-align: center">Confirmado</td>
                                        @break
                                        @case(3)
                                        <td style="text-align: center">Rechazado</td>
                                        @break
                                        @case(4)
                                        <td style="text-align: center">Demorado</td>
                                        @break
                                        @case(5)
                                        <td style="text-align: center">En producción</td>
                                        @break
                                        @case(6)
                                        <td style="text-align: center">En depósito</td>
                                        @break
                                        @case(7)
                                        <td style="text-align: center">Cancelado</td>
                                        @break
                                        @endswitch
                                        <td style="text-align: center">{{ date('d/m/Y', strtotime($orden['date']))}}
                                        </td>

                                        <td style="text-align: center">
                                            @if ($orden['order_state'] != 7 && ($workorder->state == 'Actual' ||
                                            $workorder->state == 'Actual con pedidos cancelados') )
                                            <button type="button" wire:click="cancelar({{ $orden['id'] }})"
                                                class="btn btn-danger btn-sm"> Cancelar</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center">
                                        <td colspan="100%" class="py-3 italic">No hay ordenes agregadas.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-tabs">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body table-responsive">
                    <form>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-4"> <button type="button" wire:click="comprar()"
                                            class="btn btn-info btn-sm">
                                            Comprar Materiales</button><br></div>
                                    <h3 class="card-title"> Materiales requeridos para los pedidos: </h3>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">Código</th>
                                        <th style="text-align: center">Descripción</th>
                                        <th style="text-align: center">Stock</th>
                                        <th style="text-align: center">Stock en tránsito</th>
                                        <th style="text-align: center">Stock requerido</th>
                                        @if ($workorder->state == 'Actual' || $workorder->state == 'Actual con pedidos
                                        cancelados')
                                        <th style="text-align: center">Presentaciones reservadas</th>
                                        <th style="text-align: center">Cantidades reservadas</th>
                                        <th style="text-align: center">Total</th>
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($workorder_materials as $workorder_material)
                                    <tr>
                                        <td style="text-align: center">{{ $workorder_material[1] }}</td>
                                        <td style="text-align: center">{{ $workorder_material[2] }}</td>
                                        <td style="text-align: center">{{ $workorder_material[3] }}</td>
                                        <td style="text-align: center">{{ $workorder_material[4] }}</td>
                                        <td style="text-align: center">{{ $workorder_material[5] }}</td>
                                        @if ($workorder->state == 'Actual' || $workorder->state == 'Actual con pedidos
                                        cancelados')
                                        <td style="text-align: center">
                                            @if (is_array($workorder_material[6]))
                                            @foreach ($workorder_material[6] as $presentation)
                                            <div class="row justify-content-center">
                                                <div class="col-6 border"> {{ $presentation }} </div>
                                            </div>
                                            @endforeach
                                            @else
                                            {{$workorder_material[6]}}
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if (is_array($workorder_material[7]))
                                            @foreach ($workorder_material[7] as $total)
                                            <div class="row justify-content-center">
                                                <div class="col-6 border"> {{ $total }} </div>
                                            </div>
                                            @endforeach
                                            @else
                                            {{$workorder_material[7]}}
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                                @if (is_array($workorder_material[8]))
                                                @foreach ($workorder_material[8] as $amount)
                                                <div class="row justify-content-center">
                                                    <div class="pl-2 pr-2 border"> {{ $amount }} </div>
                                                </div>
                                                @endforeach
                                                @else
                                                {{$workorder_material[8]}}
                                                @endif
                                            </td>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="mr-2">
                                                    <button type="button"
                                                        wire:click="reservar({{ $workorder_material[0] }})"
                                                        class="btn btn-success btn-sm">
                                                        Reservar</button>
                                                </div>
                                                <button type="button"
                                                    wire:click="explora_reservation({{ $workorder_material[0] }})"
                                                    class="btn btn-primary btn-sm"> Ver</button>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr class="text-center">
                                        <td colspan="100%" class="py-3 italic">No hay ordenes agregadas.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($workorder->state == 'Actual')
                        <div class="card-footer">
                            <div class="form-group">
                                <!-- <button wire:click="save()" type="button" class="btn btn-primary">Realizar orden</button> -->
                            </div>
                        </div>
                        @endif
                    </form>
                </div>

            </div>
            <div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form wire.submit.prevent="addmaterial">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Material seleccionado: <span>{{ $material_code }} - {{
                                        $material_description }}</span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Cantidad requerida: {{ (isset($workorder_materials[$material_id])) ? $workorder_materials[$material_id][5] : '' }}</label>
                                </div>
                                <div class="form-group">
                                    <label>Reserva de depósitos tipo:</label>
                                    <select class="form-control select2 select2-hidden-accessible"
                                        wire:model.defer="type_reservation"
                                        wire:change='change_reservation({{ $material_id }})' style="width: 100%;">
                                        <option selected="selected" hidden="">Seleccione una opción</option>
                                        <option>Normal</option>
                                        <option>Equilibrado</option>
                                        <option>Personalizado</option>
                                    </select>
                                </div>
                                @switch($type_reservation)
                                @case('Normal')
                                <h3 class="card-title">Seleccione depósito:</h3>
                                <br />
                                <div class="input-group input-group-sm mb-2" style="width: 130px">
                                    <input wire:model="searchdeposito" type="text"
                                        class="form-control form-control-xs float-right"
                                        placeholder="Buscar depósito..." />
                                </div>
                                @if ($searchdeposito != '')
                                <div class="card-body table-responsive p-0">
                                    <x-form-validation-errors :errors="$errors" />
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Depósito</th>
                                                <th style="text-align: center">Tipo</th>
                                                <th style="text-align: center">Presentaciones disponible</th>
                                                <th style="text-align: center">Cantidades disponible</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($normal_deposit as $index => $deposit)
                                            <tr>
                                                <td style="text-align: center">{{ $deposit->name }}</td>
                                                </td>
                                                @switch($deposit->type)
                                                @case(1)
                                                <td style="text-align: center">Almacén</td>
                                                @break
                                                @case(2)
                                                <td style="text-align: center">Producción</td>
                                                @break
                                                @endswitch
                                                <td style="text-align: center">
                                                    <select class="form-control select2 select2-hidden-accessible"
                                                        wire:model.defer="presentation_selected.{{ $material_id }}.{{ $deposit->id }}"
                                                        wire:change='change_amount({{$material_id}},{{ $deposit->id }})'
                                                        style="width: 100%;">
                                                        <option selected="selected" hidden="">Seleccione una opción
                                                        </option>
                                                        @foreach ($presentations[$material_id][$deposit->id] as
                                                        $presentation)
                                                        <option value="{{ $presentation }}">{{
                                                            $presentation->presentation }}</option>
                                                        @endforeach

                                                    </select>
                                                </td>
                                                <td style="text-align: center">
                                                    {{ (!empty($amount_presentation[$material_id][$deposit->id])) ?
                                                    $amount_presentation[$material_id][$deposit->id] : 0 }}
                                                </td>
                                                <td>
                                                    <div>
                                                        <button type="button"
                                                            wire:click.prevent="add_deposit({{ $presentations[$material_id][$deposit->id][count($presentations[$material_id][$deposit->id])-1]->id }})"
                                                            class="btn btn-success btn-sm">
                                                            Seleccionar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr class="text-center">
                                                <td colspan="4" class="py-3 italic">No existe el material en el deposito</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                @endif
                                @if (!empty($deposits[$material_id]))
                                <h3 class="card-title">Depósitos seleccionados:</h3>
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Depósito</th>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">Presentación</th>
                                            <th style="text-align: center">Cantidad disponible</th>
                                            <th style="text-align: center">Cantidad</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($deposits[$material_id] as $index => $deposit)
                                        <tr>
                                            <td style="text-align: center">{{ $deposit['name'] }}</td>
                                            @switch($deposit['type'])
                                            @case(1)
                                            <td style="text-align: center">Almacén</td>
                                            @break
                                            @case(2)
                                            <td style="text-align: center">Producción</td>
                                            @break
                                            @endswitch
                                            <td style="text-align: center">{{ $deposit['presentation'] }}</td>
                                            <td style="text-align: center">{{ $deposit['amount'] }}</td>
                                            <td style="text-align: center" class="col-sm-3">
                                                <input class="form-control form-control-sm" type="text"
                                                    wire:model.defer="amount_deposit.{{ $material_id }}.{{ $deposit['id'] }}.{{ $deposit['presentation'] }}"
                                                    placeholder="Cantidad" style="width: 50%;">
                                            </td>
                                            <td><button type="button" wire:click.prevent="down_deposit({{ $index }})"
                                                    class="btn btn-danger btn-sm">
                                                    Quitar
                                                </button></td>
                                        </tr>
                                        @empty
                                        <tr class="text-center">
                                            <td colspan="100%" class="py-3 italic">No hay depósitos seleccionados.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @endif
                                @break
                                @case('Equilibrado')
                                <h3 class="card-title">Seleccione depósito:</h3>
                                <br />
                                <div wire class="input-group input-group-sm mb-2" style="width: 130px">
                                    <input wire:model="searchdeposito" type="text"
                                        class="form-control form-control-xs float-right"
                                        placeholder="Buscar depósito..." />
                                    <br>
                                </div>
                                @if ($searchdeposito != '')
                                <div class="card-body table-responsive p-0">
                                    <x-form-validation-errors :errors="$errors" />
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Depósito</th>
                                                <th style="text-align: center">Tipo</th>
                                                <th style="text-align: center">Presentaciones disponible</th>
                                                <th style="text-align: center">Cantidades disponible</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($normal_deposit as $index => $deposit)
                                            <tr>
                                                <td style="text-align: center">{{ $deposit->name }}</td>
                                                </td>
                                                @switch($deposit->type)
                                                @case(1)
                                                <td style="text-align: center">Almacén</td>
                                                @break
                                                @case(2)
                                                <td style="text-align: center">Producción</td>
                                                @break
                                                @endswitch
                                                <td style="text-align: center">
                                                    <select class="form-control select2 select2-hidden-accessible"
                                                        wire:model.defer="presentation_selected.{{ $material_id }}.{{ $deposit->id }}"
                                                        wire:change='change_amount({{$material_id}},{{ $deposit->id }})'
                                                        style="width: 100%;">
                                                        <option selected="selected" hidden="">Seleccione una opción
                                                        </option>
                                                        @foreach ($presentations[$material_id][$deposit->id] as
                                                        $presentation)
                                                        <option value="{{ $presentation }}">{{
                                                            $presentation->presentation }}</option>
                                                        @endforeach

                                                    </select>
                                                </td>
                                                <td style="text-align: center">
                                                    {{ (!empty($amount_presentation[$material_id][$deposit->id])) ?
                                                    $amount_presentation[$material_id][$deposit->id] : 0 }}
                                                </td>
                                                <td>
                                                    <div>
                                                        <button type="button"
                                                            wire:click.prevent="add_deposit({{ $presentations[$material_id][$deposit->id][count($presentations[$material_id][$deposit->id])-1]->id }})"
                                                            class="btn btn-success btn-sm">
                                                            Seleccionar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr class="text-center">
                                                <td colspan="4" class="py-3 italic">No existe el material en el deposito</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                @endif
                                @if (!empty($deposits[$material_id]))
                                <h3 class="card-title">Depósitos seleccionados:</h3>
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Depósito</th>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">Presentación</th>
                                            <th style="text-align: center">Cantidad disponible</th>
                                            <th style="text-align: center">Cantidad</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($deposits[$material_id] as $index => $deposit)
                                        <tr>
                                            <td style="text-align: center">{{ $deposit['name'] }}</td>
                                            @switch($deposit['type'])
                                            @case(1)
                                            <td style="text-align: center">Almacén</td>
                                            @break
                                            @case(2)
                                            <td style="text-align: center">Producción</td>
                                            @break
                                            @endswitch
                                            <td style="text-align: center">{{ $deposit['presentation'] }}</td>
                                            <td style="text-align: center">{{ $deposit['amount'] }}</td>
                                            <td style="text-align: center" class="col-sm-3">
                                                <input class="form-control form-control-sm" type="text"
                                                    wire:model.defer="amount_deposit.{{ $material_id }}.{{ $deposit['id'] }}.{{ $deposit['presentation'] }}"
                                                    placeholder="Cantidad" style="width: 50%;">
                                            </td>
                                            <td><button type="button" wire:click.prevent="down_deposit({{ $index }})"
                                                    class="btn btn-danger btn-sm">
                                                    Quitar
                                                </button></td>
                                        </tr>
                                        @empty
                                        <tr class="text-center">
                                            <td colspan="100%" class="py-3 italic">No hay depósitos seleccionados.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @endif
                                @break
                                @case('Personalizado')
                                <h3 class="card-title">Seleccione depósito a ser agregado:</h3>
                                <br />
                                <div class="card-body table-responsive p-0">
                                    <x-form-validation-errors :errors="$errors" />
                                    <table class="table table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Depósito</th>
                                                <th style="text-align: center">Tipo</th>
                                                <th style="text-align: center">Presentaciones disponible</th>
                                                <th style="text-align: center">Cantidades disponible</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($material_deposits as $index => $material_deposit)
                                            @if ($material_deposit->warehouse->type == 1 || $material_deposit->warehouse->type == 2)
                                            <tr>
                                                <td style="text-align: center">{{ $material_deposit->warehouse->name }}
                                                </td>
                                                </td>
                                                @switch($material_deposit->warehouse->type)
                                                @case(1)
                                                <td style="text-align: center">Almacén</td>
                                                @break
                                                @case(2)
                                                <td style="text-align: center">Producción</td>
                                                @break
                                                @endswitch
                                                
                                                <td style="text-align: center">
                                                    <select class="form-control select2 select2-hidden-accessible"
                                                        wire:model.defer="presentation_selected.{{ $material_id }}.{{ $material_deposit->warehouse_id }}"
                                                        wire:change='change_amount({{$material_id}},{{ $material_deposit->warehouse_id }})'
                                                        style="width: 100%;">
                                                        <option selected="selected" hidden="">Seleccione una opción
                                                        </option>
                                                        @foreach ($presentations[$material_id][$material_deposit->warehouse_id] as
                                                        $presentation)
                                                        <option value="{{ $presentation }}">{{
                                                            $presentation->presentation }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="text-align: center">
                                                    {{
                                                    (!empty($amount_presentation[$material_id][$material_deposit->warehouse_id]))
                                                    ?
                                                    $amount_presentation[$material_id][$material_deposit->warehouse_id]
                                                    : 0 }}
                                                </td>
                                                <td>
                                                    <div>
                                                        <button type="button"
                                                            wire:click.prevent="add_deposit({{ $material_deposit->id }})"
                                                            class="btn btn-success btn-sm">
                                                            Seleccionar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr> 
                                            @endif
                                            @empty
                                            <tr class="text-center">
                                                <td colspan="4" class="py-3 italic">No existe el material en el deposito</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                @if (!empty($deposits[$material_id]))
                                <h3 class="card-title">Depósitos seleccionados:</h3>
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Depósito</th>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">Presentación</th>
                                            <th style="text-align: center">Cantidad disponible</th>
                                            <th style="text-align: center">Cantidad</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($deposits[$material_id] as $index => $deposit)
                                        <tr>
                                            <td style="text-align: center">{{ $deposit['name'] }}</td>
                                            @switch($deposit['type'])
                                            @case(1)
                                            <td style="text-align: center">Almacén</td>
                                            @break
                                            @case(2)
                                            <td style="text-align: center">Producción</td>
                                            @break
                                            @endswitch
                                            <td style="text-align: center">{{ $deposit['presentation'] }}</td>
                                            <td style="text-align: center">{{ $deposit['amount'] }}</td>
                                            <td style="text-align: center" class="col-sm-3">
                                                <input class="form-control form-control-sm" type="text"
                                                    wire:model.defer="amount_deposit.{{ $material_id }}.{{ $deposit['id'] }}.{{ $deposit['presentation'] }}"
                                                    placeholder="Cantidad" style="width: 50%;">
                                            </td>
                                            <td><button type="button" wire:click.prevent="down_deposit({{ $index }})"
                                                    class="btn btn-danger btn-sm">
                                                    Quitar
                                                </button></td>
                                        </tr>
                                        @empty
                                        <tr class="text-center">
                                            <td colspan="100%" class="py-3 italic">No hay depósitos seleccionados.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @endif
                                @break
                                @endswitch
                            </div>
                            <div class="modal-footer">
                                <button type="submit" wire:click.prevent="addreservation()"
                                    class="btn btn-primary btn-sm">Agregar</button>
                                <button type="button" class="btn btn-danger btn-sm" wire:click.prevent="backmodal()"
                                    data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div wire:ignore.self class="modal" id="form-reservation" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form wire.submit.prevent="addmaterial">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Material seleccionado: <span>{{ $material_code }} - {{
                                        $material_description }}</span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h3 class="card-title">Reservaciones del material:</h3>
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Depósito</th>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">Presentación</th>
                                            <th style="text-align: center">Cantidad Reservada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($reservation as $reservation_material)
                                        <tr>
                                            @if (!empty($reservation_material->reservationdeposit))
                                            <td style="text-align: center">{{
                                                $reservation_material->reservationdeposit->warehouse->name }}</td>
                                            @switch($reservation_material->reservationdeposit->warehouse->type)
                                            @case(1)
                                            <td style="text-align: center">Almacén</td>
                                            @break
                                            @case(2)
                                            <td style="text-align: center">Producción</td>
                                            @break
                                            @endswitch
                                            <td style="text-align: center">{{ $reservation_material->presentation }}
                                            </td>
                                            <td style="text-align: center">{{ $reservation_material->amount }}</td>
                                            @endif
                                        </tr>
                                        @empty
                                        <tr class="text-center">
                                            <td colspan="100%" class="py-3 italic">No hay reservaciones para este
                                                material.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"
                                    wire:click.prevent="backmodal()">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>

</div>