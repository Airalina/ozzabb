@if ($showSelection)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Seleccione revisión a ser agregada:</h3>
            <br>
            <div class="input-group input-group-sm" style="width: 150px;">
                <input wire:model="searchRevisions" type="text" class="form-control form-control-xs float-right"
                    placeholder="Buscar revisión...">
            </div>
        </div>
        <!-- /.card-header -->
        @if ($searchRevisions != '')
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="text-align: center">N° de revisión</th>
                            <th style="text-align: center">Razón</th>
                            <th style="text-align: center">Fecha de creación</th>
                            <th style="text-align: center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($revisions as $revision)
                            <tr>
                                <td style="text-align: center">{{ $revision['number_version'] }}</td>
                                <td style="text-align: center">{{ $revision['reason'] }}</td>
                                <td style="text-align: center">{{ date('d-m-Y', strtotime($revision['create_date'])) }}
                                </td>
                                <td><button type="button" wire:click="selectRevision({{ $revision['id'] }})"
                                        class="btn btn-success btn-sm">Seleccionar</button></td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="100%" class="py-3 italic">No hay información</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
        <!-- /.card-body -->
    </div>
@endif
<!-- /.card -->
<x-list-revisions-card :revisions="$revisionSelected" showActions='0' />
