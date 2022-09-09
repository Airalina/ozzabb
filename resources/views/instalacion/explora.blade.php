<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Detalle de instalación</h3>
        </div>
        <form>
            <div class="card-body">
                <x-form-validation-errors :errors="$errors" />
                <x-form-create-installation disabled='disabled' :customersData="$customersData" />
                <div class="card-tools">
                    <div>
                        <button wire:click="newRevision()" type="button" class="btn btn-info btn-sm">Nueva
                            Revisión</button>
                    </div>
                </div>
                @if (count($installation['revisions']) > 0)
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
                            @forelse($installation['revisions'] as $revision)
                                <tr>
                                    <td style="text-align: center">{{ $revision['number_version'] }}</td>
                                    <td style="text-align: center">{{ $revision['reason'] }}</td>
                                    <td style="text-align: center">
                                        {{ date('d-m-Y', strtotime($revision['create_date'])) }}</td>
                                    <td style="text-align: center">
                                        <button type="button"
                                            wire:click="explorarRevision({{ $revision['id'] }})"
                                            class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                                        @if (auth()->user()->can('updateinstall', auth()->user()))
                                            <button type="button"
                                                wire:click="editRevision({{ $revision['id'] }})"
                                                class="btn btn-success btn-sm"> Actualizar</button>
                                        @endif
                                        @if (auth()->user()->can('deleteinstall', auth()->user()))
                                            <button type="button" wire:click="destroyRevision({{ $revision['id'] }})"
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
                @endif
            </div>
            @include('borrar')
    </div>
</div>
