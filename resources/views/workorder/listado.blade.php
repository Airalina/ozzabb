<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Órdenes de trabajo</h3>
            <div class="card-tools">
                <div class="d-flex justify-content-end mb-4">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input wire:model="search" type="text" class="form-control" placeholder="Buscar orden...">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <br>
                    <div class="p-1 mr-2 text-secondary">
                        <p><i class="fas fa-filter"></i></p>
                    </div>
                    <div>
                        <select select class="form-control form-control-sm select2 select2-hidden-accessible"
                            wire:model="filtro" id="filtro" style="width: 100%;">
                            <option selected value="">Filtrar</option>
                            <option>Estado</option>
                            <option>Fechas</option>
                        </select>
                    </div>
                    <br>
                </div>
                <div class="d-flex justify-content-end">
                    @if ($filtro == 'Estado')
                    <select select class="form-control form-control-sm select2 select2-hidden-accessible"
                        wire:model="type_state" id="type_state" style="width: 100%;">
                        <option selected hidden>-</option>
                        <option>Nueva</option>
                        <option>Actual</option>
                        <option>Finalizada</option>
                        <option>Actual con pedidos cancelados</option>
                        <option>Finalizada con pedidos cancelados</option>
                    </select>
                    @elseif ($filtro == 'Fechas')
                    <div class="d-flex flex-row bd-highlight mb-3">
                        <div class="form-group">
                            <div class="row">
                                <p>Desde: </p>
                                <div class="col-4">
                                    <input type="date" wire:model="from" class="form-control form-control-sm"
                                        style="width: auto;" placeholder="dd/mm/AAAA" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group ml-4">
                            <div class="row"><p>Hasta: </p>
                                <div class="col-4">
                                    <input type="date" wire:model="to" class="form-control form-control-sm"
                                        style="width: auto;" placeholder="dd/mm/AAAA" >
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
                    <button wire:click="create()" type="button" class="btn btn-info btn-sm">Agregar Orden
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-head  table-sm">
                <thead>
                    <tr>
                        <th style="text-align: center">ID</th>
                        <th style="text-align: center">Código</th>
                        <th style="text-align: center">Fecha Inicio</th>
                        <th style="text-align: center">Fecha Final</th>
                        <th style="text-align: center">Estado</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($workorders as $workorder)
                    <tr class="registros">
                        <td style="text-align: center">{{ $workorder->id }}</td>
                        <td style="text-align: center">{{ $workorder->code }}</td>
                        <td style="text-align: center">{{ date('d-m-Y', strtotime($workorder->start_date)) }}</td>
                        <td style="text-align: center">{{ date('d-m-Y', strtotime($workorder->end_date)) }}</td>
                        <td style="text-align: center">{{ $workorder->state }}</td>
                        <td style="text-align: center">
                            <button type="button" wire:click="explora({{ $workorder->id }})"
                                class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                            @if ($workorder->state == 'Nueva')
                            <button type="button" wire:click="update({{ $workorder->id }})"
                                class="btn btn-success btn-sm"> Actualizar</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="4" class="py-3 italic">No hay información</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $workorders->links() }}
        </div>
        <!-- /.card-body -->
    </div>
</div>