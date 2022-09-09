<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Instalaciones Registradas</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input wire:model="searchInstallations" type="text" class="form-control float-right"
                        placeholder="Buscar Instalacion...">
                </div>
            </div>

        </div>
        <div class="card-header">
            <div>
                <label class="float-left">Registros por página:</label><input style="width: 60px; height: 30px"
                    type="number" min="1" wire:model="pages" class="form-control">
            </div>
            <div class="card-tools">
                @if (auth()->user()->can('storeinstall', auth()->user()))
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Agregar
                            Instalaciones</button>
                    </div>
                @endif
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-head table-sm">
                <div class="form-group">
                    <label>Ordenar por</label>
                    <select wire:model="order" class="form-control" style="width: 100%;" tabindex="-1">
                        <option value="code">Código</option>
                        <option value="description">Descripción</option>
                        <option value="usd_price">Precio U$D</option>
                    </select>
                </div>
                <thead>
                    <tr>
                        <th style="text-align: center">Código</th>
                        <th style="text-align: center">Descripción</th>
                        <th style="text-align: center">Cliente</th>
                        <th style="text-align: center">Precio U$D</th>
                        <th style="text-align: center">Fecha de Ingreso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($installations as $installation)
                        <tr>
                            <td style="text-align: center">{{ $installation->code }}</td>
                            <td style="text-align: center">{{ $installation->short_description }}</td>
                            <td style="text-align: center">{{ $installation->customer->name ?? ' ' }}</td>
                            <td style="text-align: center">{{ $installation->usd_price }}</td>
                            <td style="text-align: center">{{ date('d-m-Y', strtotime($installation->date_admission)) }}
                            </td>
                            <td style="text-align: center">
                                <button type="button" wire:click="explorar({{ $installation->id }})"
                                    class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                                @if (auth()->user()->can('updateinstall', auth()->user()))
                                    <button type="button" wire:click="edit({{ $installation->id }})"
                                        class="btn btn-success btn-sm">Actualizar</button>
                                @endif
                                @if (auth()->user()->can('deleteinstall', auth()->user()))
                                    <button type="button" wire:click="destroy({{ $installation->id }})"
                                        class="btn btn-danger btn-sm">Borrar</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="100%" class="py-3 italic">No hay información</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $installations->links() }}
        </div>
        <!-- /.card-body -->
        @include('borrar')
    </div>
</div>
