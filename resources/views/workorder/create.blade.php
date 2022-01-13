<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div><br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Nueva orden de trabajo</h3>
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
            <h5>Datos de orden de trabajo</h5>
            <div class="card-body">
                <div class="form-group">
                    <label>Código</label>
                    <div class="row">
                        <div class="col-2">
                            <input class="form-control form-control-sm" type="text" wire:model="code"
                                placeholder="Código de orden">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fecha de Inicio</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="date" wire:model="start_date" class="form-control form-control-sm"
                                style="width: auto;" placeholder="dd/mm/AAAA">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fecha de Finalización</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="date" wire:model="end_date" class="form-control form-control-sm"
                                style="width: auto;" placeholder="dd/mm/AAAA">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Horas de trabajo disponibles</label>
                    <div class="row">
                        <div class="col-3">
                            <input class="form-control form-control-sm" type="text" wire:model="hours"
                                placeholder="Horas de trabajo disponibles">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Cantidad de empleados disponibles</label>
                    <div class="row">
                        <div class="col-3">
                            <input class="form-control form-control-sm" type="text" wire:model="man"
                                placeholder="Cantidad de empleados disponibles">
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
                <div class="card-header">
                    <h3 class="card-title">Pedidos de clientes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    @if (!empty($end_date))
                    <div class="card-header">
                        <h3 class="card-title">Seleccione pedido a ser agregado:</h3>
                        <br />
                        <div class="input-group input-group-sm" style="width: 130px">
                            <input wire:model="searchpedido" type="text"
                                class="form-control form-control-xs float-right" placeholder="Buscar pedido..." />
                        </div>

                    </div>
                    @else
                    <div class="card-header">
                        <h3 class="card-title">Se requiere 'Fecha de finalización' para ver los pedidos</h3>
                    </div>
                    @endif
                    @if ($searchpedido != '')

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Nombre del cliente</th>
                                    <th style="text-align: center">Fecha estimada</th>
                                    <th style="text-align: center">Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td style="text-align: center">{{ $order->id }}</td>
                                    <td style="text-align: center">{{ $order->customer_name }}</td>
                                    <td style="text-align: center">{{ date('d/m/Y', strtotime($order->deadline)) }}
                                    </td>
                                    @switch($order->order_state)
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
                                    <td>
                                        <div>
                                            <button type="button" wire:click="addorder({{ $order->id }})"
                                                class="btn btn-success btn-sm">
                                                Agregar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="text-center">
                                    <td colspan="4" class="py-3 italic">No hay información</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @error('order') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>
            </div>
            <div class="card card-tabs">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body table-responsive">
                    <form>
                        <div class="card-header">
                            <h3 class="card-title">Pedidos de clientes seleccionados:</h3>
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
                                        <td style="text-align: center">{{ $orden['id'] }}/{{ date('Y', strtotime($orden['date']))}}</td>
                                        <td style="text-align: center">{{ $orden['customer_name'] }}</td>
                                        <td style="text-align: center">{{ date('d/m/Y', strtotime($orden['date']))}}</td>
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
                                        <td style="text-align: center">{{ date('d/m/Y', strtotime($orden['date']))}}</td>
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
                                    <h3 class="card-title"> Materiales requeridos para los pedidos seleccionados: </h3>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clientorders as $clientorder)
                                    <tr>
                                        <td style="text-align: center">{{ $clientorder[1] }}</td>
                                        <td style="text-align: center">{{ $clientorder[2] }}</td>
                                        <td style="text-align: center">{{ $clientorder[3] }}</td>
                                        <td style="text-align: center">{{ $clientorder[4] }}</td>
                                        <td style="text-align: center">{{ $clientorder[5] }}</td>
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

        </div>
    </form>
    <div class="card-footer">
        <div class="form-group">
        @if($funcion=="crear")
                        <td><button wire:click="save()" type="button" class="btn btn-primary">Realizar orden</button></td>
				@else
						<td><button wire:click="editar()" type="button" class="btn btn-primary">Guardar Cambios</button></td>
				@endif
                        <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
         </div>
    </div>
</div>