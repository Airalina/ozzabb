<div class="col">
    <div class="card mb-3 border-dark">
        <div class="card-header">
            @if ($addprovider)
                <div class="form-group">
                    <button wire:click="addProvider()" type="button" class="btn btn-info btn-sm">Agregar
                        proveedor nuevo</button>
                </div>
            @endif
            <h3 class="card-title">Seleccione proveedor a ser agregado:</h3>
            <br>
            <div class="input-group input-group-sm" style="width: 150px;">
                <input wire:model="searchproviders" type="text" class="form-control form-control-xs float-right mb-4"
                    placeholder="Buscar proveedor...">
            </div>

            @if ($searchproviders != '')
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Nombre y Apellido</th>
                                <th style="text-align: center">Email</th>
                                <th style="text-align: center">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($providers as $provider)
                                <tr>
                                    <td style="text-align: center">{{ $provider->id }}</td>
                                    <td style="text-align: center">{{ $provider->name }}</td>
                                    <td style="text-align: center">
                                        {{ $provider->email }}</td>
                                    <td style="text-align: center"><button type="button"
                                            wire:click="selectprovider({{ $provider->id }})"
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
            @if (isset($providerselected))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Proveedor seleccionado:</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Nombre y Apellido</th>
                                    <th style="text-align: center">Email</th>
                                    <th style="text-align: center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">{{ $providerselected->id }}</td>
                                    <td style="text-align: center">{{ $providerselected->name }}</td>
                                    <td style="text-align: center">{{ $providerselected->email }}</td>
                                    <td style="text-align: center"><button type="button" wire:click="downprovider"
                                            class="btn btn-danger btn-sm">Quitar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            @endif

            <x-form-create-price />

        </div>
    </div>
</div>
