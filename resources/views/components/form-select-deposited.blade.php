<div class="card">
    <div class="card-header">
        <div class="card-tools">
            @if ($process == 'ingreso' && empty($warehouseSelected))
                <button wire:click="createProduct('{{ $type }}')" type="button" float="right"
                    class="btn btn-info btn-sm">Agregar
                    {{ $type }}</button>
            @endif
        </div>
        <h3 class="card-title">Seleccione {{ $type }} a ser agregado:</h3>
        <br>
        <div class="input-group input-group-sm" style="width: 150px;">
            <input wire:model="{{ $searchType }}" type="text" class="form-control form-control-xs float-right"
                placeholder="Buscar {{ $type }} ...">
        </div>
    </div>
    <!-- /.card-header -->
    @if ($searchType != '')
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align: center">Código</th>
                        <th style="text-align: center">Descripción</th>
                        @if ($type == 'material')
                            <th style="text-align: center">Familia</th>
                        @endif
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td style="text-align: center">{{ $product->code ?? $product->id }}
                            </td>
                            <td style="text-align: center">
                                {{ $product->description }}</td>
                            @if ($type == 'material')
                                <td style="text-align: center">{{ $product->family }}
                                </td>
                            @endif
                            <td><button type="button"
                                    wire:click="selectProduct({{ $product->id }}, '{{ $type }}')"
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

@if (!empty($productsSelected))
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Seleccionados:</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align: center">Código</th>
                        <th style="text-align: center">Descripción</th>
                        @if ($type == 'material')
                            <th style="text-align: center">Packaging</th>
                        @elseif ($type == 'instalacion')
                            <th style="text-align: center">N° de revisión</th>
                            <th style="text-align: center">N° de serie</th>
                            <th style="text-align: center">N° de pedido de cliente</th>
                        @endif
                        <th style="text-align: center">Cantidad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productsSelected as $typeProduct => $products)
                        @foreach ($products as $product)
                            <tr>
                                <td style="text-align: center">{{ $product['code'] }}</td>
                                <td style="text-align: center">{{ $product['description'] }}</td>
                                @if ($type == 'material')
                                    <td style="text-align: center">
                                        <x-show-list-elements :items="$product['packaging']" />
                                    </td>
                                @elseif ($type == 'instalacion')
                                    <td style="text-align: center">{{ $product['number_version'] }}</td>
                                    <td style="text-align: center">{{ $product['serial_number'] }}</td>
                                    <td style="text-align: center">{{ $product['client_order_id'] }}</td>
                                @endif
                                <td style="text-align: center">
                                    <x-show-list-elements :items="$product['amount']" />
                                </td>
                                <td style="text-align: center"><button type="button"
                                        wire:click="downProduct({{ $product['id'] }}, '{{ $typeProduct }}')"
                                        class="btn btn-danger btn-sm">Quitar</button></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->

    </div>
    <!-- /.card -->
@endif
