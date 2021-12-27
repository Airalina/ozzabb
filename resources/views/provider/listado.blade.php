<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Proveedores Registrados</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input wire:model="search" type="text" class="form-control float-right"
                        placeholder="Buscar Proveedor...">
                </div>
            </div>
        </div>
        <div class="card-header">
            <div>
                <label class="float-left">Registros por página:</label><input style="width: 60px; height: 30px"
                    type="number" min="1" wire:model="paginas" class="form-control">
            </div>
            <div class="card-tools">
                @if (auth()->user()->can('storeprovider', auth()->user()))
                <div class="input-group input-group-sm" style="width: 150px;">
                    <button wire:click="funcion()" type="button" class="btn btn-info btn-sm">Agregar
                        Proveedor</button>
                </div>
                @endif
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-head table-sm">
                <div class="form-group" data-select2-id="45">
                    <label>Ordenar por</label>
                    <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="47" value="id">Id</option>
                        <option data-select2-id="48" value="name">Nombre</option>
                        <option data-select2-id="49" value="address">Dirección</option>
                        <option data-select2-id="50" value="phone">Teléfono</option>
                        <option data-select2-id="51" value="email">Email</option>
                        <option data-select2-id="52" value="contact_name">Nombre de contacto</option>
                        <option data-select2-id="53" value="point_contact">Puesto de contacto</option>
                        <option data-select2-id="54" value="site_url">Página web</option>
                    </select>
                </div>
                <thead>
                    <tr>
                        <th style="text-align: center">Nombre</th>
                        <th style="text-align: center">Domicilio</th>
                        <th style="text-align: center">Teléfono</th>
                        <th style="text-align: center">Correo electrónico</th>
                        <th style="text-align: center">CUIT</th>
                        <th style="text-align: center">Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($providers as $provider)
                    <tr class="registros">
                        <td style="text-align: center">{{ $provider->name }}</td>
                        <td style="text-align: center">{{ $provider->address }}</td>
                        <td style="text-align: center">{{ $provider->phone }}</td>
                        <td style="text-align: center">{{ $provider->email }}</td>
                        <td style="text-align: center">{{ $provider->cuit }}</td>
                        @if ($provider->status == 1)
                        <td style="text-align: center">Activo</td>
                        @else
                        <td style="text-align: center">Inactivo</td>
                        @endif
                        <td style="text-align: center">
                            <button type="button" wire:click="explorar({{ $provider->id }})"
                                class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                            @if (auth()->user()->can('updateprovider', auth()->user()))
                            <button wire:click="update({{ $provider->id }})" type="button"
                                class="btn btn-success btn-sm">Actualizar</button>
                            @endif
                            @if (auth()->user()->can('deleteprovider', auth()->user()))
                            <button wire:click="destruir({{ $provider->id }})" type="button"
                                class="btn btn-danger btn-sm">Borrar</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="10" class="py-3 italic">No hay información</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $providers->links() }}
        </div>
        @include('borrar')
        <!-- /.card-body -->
    </div>
</div>