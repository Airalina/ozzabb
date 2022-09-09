<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Depositos</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input wire:model="search" type="text" class="form-control float-right"
                        placeholder="Buscar depósito...">
                </div>
            </div>
        </div>
        <div class="card-header">
            <div>
                <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px"
                    type="number" min="1" wire:model="paginas" class="form-control">
            </div>
            <div class="card-tools">
                @if (auth()->user()->can('storedepo', auth()->user()))
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Agregar
                            Depósito</button>
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
                        <option data-select2-id="47" value="type">Tipo</option>
                        <option data-select2-id="48" value="name">Nombre</option>
                        <option data-select2-id="49" value="location">Ubicación</option>
                        <option data-select2-id="50" value="description">Propósito</option>
                    </select>
                </div>
                <thead>
                    <tr>
                        <th style="text-align: center">Nombre</th>
                        <th style="text-align: center">Tipo</th>
                        <th style="text-align: center">Ubicación</th>
                        <th style="text-align: center">Propósito</th>
                        <th style="text-align: center">Fecha de Creación</th>
                        <th style="text-aling: center">Temporal</th>
                        <th style="text-align: center; width:70px">Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $deposit)
                        <tr>
                            <td style="text-align: center">{{ $deposit->name }}</td>
                            <td style="text-align: center">{{ $types[$deposit->type] }}</td>
                            <td style="text-align: center">{{ $deposit->location }}</td>
                            <td style="text-align: center">{{ $deposit->short_description }}</td>
                            <td style="text-align: center">
                                {{ date('d-m-Y', strtotime($deposit->create_date)) }}</td>
                            <td style="text-align: center">{{ $deposit->temporary ? 'Sí' : 'No' }}
                            </td>
                            <td style="text-align: center">{{ $states[$deposit->state] }}</td>
                            <td style="text-align: center">
                                <button type="button" wire:click="explorar({{ $deposit->id }})"
                                    class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i>
                                    Ver</button>
                                @if (auth()->user()->can('updatedepo', auth()->user()))
                                    <button type="button" wire:click="edit({{ $deposit->id }})"
                                        class="btn btn-success btn-sm">Actualizar</button>
                                @endif
                                @if (auth()->user()->can('deletedepo', auth()->user()))
                                    <button type="button" wire:click=" destroy({{ $deposit }})"
                                        class="btn btn-danger btn-sm">Borrar</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td style="text-align: center" colspan="100%" class="py-3 italic">No hay
                                información</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $deposits->links() }}
        </div>
        <!-- /.card-body -->
        @include('borrar')
    </div>
</div>
