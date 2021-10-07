<div>
    <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title">Solicitud de pedidos</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <form>
                <div class="card-header">
                    <h3 class="card-title">Seleccione pedido a ser agregado:</h3>
                    <br />

                    <div wire:ignore class="input-group input-group-sm" style="width: 130px">
                        <input wire:model="search" type="text" class="form-control form-control-xs float-right"
                            wire:change="order_change" placeholder="Buscar pedido..." />
                    </div>

                </div>
                @if ($search != '')

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Nombre del cliente</th>
                                    <th style="text-align: center">Fecha estimada</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $ord => $order)
                                    <tr>
                                        <td style="text-align: center">{{ $order->id }}/2021</td>
                                        <td style="text-align: center">
                                            {{ $order->customer_name }}
                                        </td>
                                        <td style="text-align: center">
                                            {{ $order->deadline->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <div>
                                                <button type="button" wire:click="addorder({{ $order->id }})"
                                                    class="btn btn-success btn-xs">
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
                    </div>
                @endif
                @if ($select)
                    <div class="form-group">
                        @if (isset($msg))
                            <span class="alert alert-danger"> {{ $msg }}</span>
                        @endif
                        <table class="table table-head text-nowrap">
                            <thead>
                                <tr>
                                    <th>Código Pedido</th>
                                    <th>Fecha entrega</th>
                                    <th>Cantidad total</th>
                                    <th>Estado</th>
                                    <th>Compras</th>
                                    <th>Fecha de inicio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($clientorders)
                                    @forelse($clientorders as $key => $clientorder)
                                        @if (isset($clientorder->id))
                                            <tr class="registros">
                                                <td>{{ $clientorder->id }} </td>
                                                <td>{{ $clientorder->deadline->format('d-m-Y') }} </td>
                                                <td>{{ $total_amount[$key] }} </td>
                                                <td>{{ $clientorder->order_state }} </td>
                                                <td>
                                                    @if (!empty($buys))
                                                        No
                                                    @else
                                                        Sí
                                                    @endif
                                                </td>
                                                <td> {{ isset($clientorder->created_at) ? $clientorder->created_at->format('d-m-Y') : '' }}
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <div> No hay registros</div>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                        <label>Fecha planilla de compras</label>
                        <div class="input-group input-group-sm">
                            <div>
                                <input wire:model="date" type="date" class="form-control" wire:change="order_change"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <x-form-validation-errors :errors="$errors" />
                    @if ($pedidos)
                        <div>
                            @if (isset($msg_error))
                                @foreach ($msg_error as $errormessage)
                                    <span class="alert alert-danger"> {{ $errormessage }}</span>
                                @endforeach
                            @endif
                        </div>
                        <table class="table table-head text-nowrap">
                            <thead>
                                <tr>
                                    <th>Código de material</th>
                                    <th>Descripción</th>
                                    <th>Presentación</th>
                                    <th>Stock</th>
                                    <th>En tránsito</th>
                                    <th>Necesidad</th>
                                    <th>Proveedor</th>
                                    <th>Comprar</th>
                                    <th>Precio de la compra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($materials))
                                    @forelse($materials as $key => $mat)
                                        @if (isset($mat->material->id))
                                            <tr class="registros">
                                                <td>{{ $mat->material->code }} </td>
                                                <td>{{ $mat->material->description }} </td>
                                                <td>
                                                    @if ($select_present)
                                                        <div>
                                                            <select wire:model="presentation" id="presentation"
                                                                class="form-control form-control-sm"
                                                                wire:change="order_change()">
                                                                <option>Seleccione una presentación </option>
                                                                @if (!empty($present[$key]))
                                                                    @foreach ($present[$key] as $prov)
                                                                        @if (!empty($prov->id))
                                                                            <option
                                                                                value='{"material_id":{{ $prov->material_id }}, "unit":{{ $prov->unit }}}'>
                                                                                {{ $prov->unit }}
                                                                                {{ $prov->presentation }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                    @endif

                                        @endif
                                        </td>
                                        <td>
                                            {{ $mat->material->stock }}
                                        </td>
                                        <td> {{ isset($transit[$key]) ? $transit[$key] : '' }}</td>
                                        <td> {{ isset($req[$key]) ? $req[$key] : '' }}</td>
                                        <td>
                                            @if($selection_provider)
                                            <div wire:ignore>
                                                <select wire:model="provider" id="provider"
                                                    class="form-control form-control-sm" wire:change="order_change()">
                                                    <option>Seleccione un proveedor</option>
                                                    @foreach ($providers[$key] as $provider)
                                                        <option
                                                            value='{"material_id":{{ $provider->material_id }},"provider_id":{{ $provider->provider_id }},"unit":{{ $provider->unit }}}'>
                                                            {{ $provider->provider->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                        </td>
                                        <td>

                                            @if (!empty($cantidad[$key]))
                                                <div wire:ignore>
                                                    <input class="form-control form-control-sm" type="text"
                                                        wire:model="amount.{{ $key }}"
                                                        wire:change="order_change()" placeholder="Cantidad">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ isset($comprar[$key]) ? $comprar[$key] : '' }}</td>
                                        </tr>
                                    @endif
                                @empty
                                    <div> No hay registros</div>
                                @endforelse
                            </tbody>
                        </table>
                    @endif

                @endif


                <label>Subtotal</label>
                <p>{{ isset($subtotal) ? $subtotal : '-' }}</p>
                <label>IVA(%)</label>
                <input class="form-control form-control-sm" type="text" wire:model="iva" wire:change="order_change()"
                    placeholder="IVA" style="width: 40px;">
                <label>Precio total</label>

                <p>{{ isset($total_price) ? $total_price : '-' }}</p>

                <div class="form-group">
                    <button wire:click="save()" type="button" class="btn btn-primary">Realizar pedido</button>
                </div>


                @endif
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</div>
