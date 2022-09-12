<div class="card">
    @if (count($addresses) > 0 && empty($addressSelected))
        <div class="card-header">
            <h3 class="card-title">Seleccione domicilio de entrega:</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align: center">Calle</th>
                        <th style="text-align: center">Número</th>
                        <th style="text-align: center">Localidad</th>
                        <th style="text-align: center">Provincia</th>
                        <th style="text-align: center">País</th>
                        <th style="text-align: center">Código Postal</th>
                        <th style="text-align: center">
                            <button type="button" wire:click="createAddress()" class="btn btn-primary btn-sm"> Nueva
                                dirección
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($addresses as $address)
                        <tr>
                            <td style="text-align: center">{{ $address['street'] }}</td>
                            <td style="text-align: center">{{ $address['number'] }}</td>
                            <td style="text-align: center">{{ $address['location'] }}</td>
                            <td style="text-align: center">{{ $address['province'] }}</td>
                            <td style="text-align: center">{{ $address['country'] }}</td>
                            <td style="text-align: center">{{ $address['postcode'] }}</td>
                            <td style="text-align: center">
                                <button type="button" wire:click="selectAddress({{ $address['id'] }})"
                                    class="btn btn-success btn-sm">Seleccionar</button>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="100%" class="py-3 italic">No hay información</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Domicilio de entrega:</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="text-align: center">Calle</th>
                            <th style="text-align: center">Número</th>
                            <th style="text-align: center">Localidad</th>
                            <th style="text-align: center">Provincia</th>
                            <th style="text-align: center">País</th>
                            <th style="text-align: center">Código Postal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center">{{ $addressSelected['street'] }}</td>
                            <td style="text-align: center">{{ $addressSelected['number'] }}</td>
                            <td style="text-align: center">{{ $addressSelected['location'] }}</td>
                            <td style="text-align: center">{{ $addressSelected['province'] }}</td>
                            <td style="text-align: center">{{ $addressSelected['country'] }}</td>
                            <td style="text-align: center">{{ $addressSelected['postcode'] }}</td>
                            <td style="text-align: center">
                                <button type="button" wire:click="downAddress({{ $addressSelected['id'] }})"
                                    class="btn btn-danger btn-sm">Quitar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endif
</div>
