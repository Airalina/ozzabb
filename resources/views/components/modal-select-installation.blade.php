<div wire:ignore.self class="modal" id="form-installation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form wire.submit.prevent="addinstallation">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Instalación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-form-validation-errors :errors="$errors" />
                    @if (count($installation) > 0)
                        <div class="form-group">
                            <p><label>Código: </label> {{ $installation['code'] }}</p>
                        </div>
                        <div class="form-group">
                            <p><label>Descripción: </label> {{ $installation['description'] }}</p>
                        </div>
                        <div class="form-group">
                            <p><label>Precio Unitario: </label> {{ $installation['usd_price'] }}</p>
                        </div>
                        <div class="form-group">
                            <label>Cantidad:</label>
                            <input wire:model.defer="installation.amount" type="number" min="0">
                        </div>
                        <div class="form-group">
                            <label>Revisión seleccionada:</label>
                            <x-selection-list-revisions :revisionSelected="$installation['revisionSelected']" :searchRevisions="$searchRevisions" :revisions="$revisions"
                                :showSelection='$showSelection' />
                        </div>
                        @if (count($installation['materials']) > 0)
                            <div class="form-group table-responsive">
                                <label>Materiales de la revisión:</label>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Código Material</th>
                                            <th style="text-align: center">Descripción</th>
                                            <th style="text-align: center">Cantidad</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($installation['materials'] as $material)
                                            <tr>
                                                <td style="text-align: center">{{ $material['code'] }}</td>
                                                <td style="text-align: center">{{ $material['description'] }}</td>
                                                <td style="text-align: center">{{ $material['amount'] }}</td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="4" class="py-3 italic">No hay información</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" wire:click.prevent="addInstallation()"
                        class="btn btn-primary btn-sm">Agregar</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"
                        wire:click.prevent="backModal()">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
