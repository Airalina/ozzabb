<div class="card-body table-responsive p-0">

    <table class="table table-hover text-nowrap text-center">
        <thead>

            <div class="card-tools">
                <div>
                    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                        Volver</button>
                </div>
                <br>
                <h6> Usted a seleccionado el material con codigo: {{ $material->id }} </h6>
            </div>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Familia</th>
                <th>Color</th>
                <th>Linea</th>
                <th>Uso</th>
                <th>Remplazo</th>
                <th>Stock Min.</th>
                <th>Stock Max.</th>
                <th>Stock</th>
                <th>
                <th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $material->id }} </td>
                <td>{{ $material->code }} </td>
                <td>{{ $material->name }} </td>
                <td>{{ $material->family }} </td>
                <td>{{ $material->color }} </td>
                <td>
                    @if ($material->line != null)
                        {{ $material->line->name }}
                    @endif
                </td>
                <td>
                    @if ($material->usage != null)
                        {{ $material->usage->name }}
                    @endif
                </td>
                <td>
                    @if ($material->material != null)
                        {{ $material->material->name }}
                    @endif
                </td>
                <td>{{ $material->stock_min }} </td>
                <td>{{ $material->stock_max }} </td>
                <td>{{ $material->stock }} </td>
                <td>
                    @if (auth()->user()->can('updateprovider', auth()->user()))
                        <button wire:click="update({{ $material->id }})" type="button"
                            class="btn btn-primary btn-sm">Actualizar</button>
                    @endif
                    @if (auth()->user()->can('deleteprovider', auth()->user()))
                        <button wire:click="destruir({{ $material->id }})" type="button"
                            class="btn btn-danger btn-sm">Borrar</button>
                    @endif
                <td>
            </tr>
        </tbody>
    </table>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-body">
                <div>
                    <div class="p-0">
                        <div class="d-flex justify-content-center">
                            @if ($material->image != null)
                                @php  $new = json_decode($material->image); @endphp
                                @foreach ($new as $mat)
                                    <img class="img-thumbnail w-25" src="{{ $material->getUrl($mat) }}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de precios del material</h3>
                <div class="card-tools">
                    @if (auth()->user()->can('storeprovider', auth()->user()))
                        <div>
                            <button wire:click="agregamat({{ $material->id }})" type="button"
                                class="btn btn-info">Agregar Precio</button>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>Código de Material</th>
                            <th>Nombre del Material</th>
                            <th>Nombre del proveedor</th>
                            <th>Unidad de presentación</th>
                            <th>Fecha</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($provider_prices as $provider_price)
                            <tr>
                                <td>{{ $provider_price->material->code }}</td>
                                <td>{{ $provider_price->material->name }}</td>
                                <td>{{ $provider_price->provider->name }}</td>
                                <td>{{ $provider_price->unit }} {{ $provider_price->presentation }}</td>
                                <td>{{ $provider_price->created_at->format('d/m/Y') }}</td>
                                <td>{{ $provider_price->usd_price }}</td>

                                @if (auth()->user()->can('deleteprovider', auth()->user()))
                                    <td><button wire:click="updatemat({{ $provider_price->id }})" type="button"
                                            class="btn btn-success btn-sm">Actualizar</button></td>
                                @endif
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4" class="py-3 italic">No hay información</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
