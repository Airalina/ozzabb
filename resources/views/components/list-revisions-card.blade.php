@if (count($revisions) > 0)
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
                    <td style="text-align: center">
                        {{ date('d-m-Y', strtotime($revision['create_date'])) }}</td>
                    <td style="text-align: center">
                        @if ($showActions)
                            <button type="button" wire:click="explorarRevision({{ $revision['id'] }})"
                                class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                            @if (auth()->user()->can('updateinstall', auth()->user()))
                                <button type="button" wire:click="editRevision({{ $revision['id'] }})"
                                    class="btn btn-success btn-sm"> Actualizar</button>
                            @endif
                            @if (auth()->user()->can('deleteinstall', auth()->user()))
                                <button type="button" wire:click="destroyRevision({{ $revision['id'] }})"
                                    class="btn btn-danger btn-sm">Borrar</button>
                            @endif
                        @else
                            <button type="button" wire:click="downRevision()"
                                class="btn btn-danger btn-sm">Quitar</button>
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
@endif
