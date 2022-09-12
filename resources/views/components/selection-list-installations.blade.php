<div class="card">
    <div class="card-header">
        <h3 class="card-title">Seleccione instalación a ser agregada:</h3>
        <br>
        <div class="input-group input-group-sm" style="width: 150px;">
            <input wire:model="searchInstallations" type="text" class="form-control form-control-xs float-right"
                placeholder="Buscar instalaciones...">
        </div>
    </div>
    <!-- /.card-header -->
    @if ($searchInstallations != '')
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align: center">Código</th>
                        <th style="text-align: center">Descripción</th>
                        <th style="text-align: center">P/U U$D</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($installations as $installation)
                        <tr>
                            <td style="text-align: center">{{ $installation['code'] }}</td>
                            <td style="text-align: center">{{ $installation['description'] }}</td>
                            <td style="text-align: center">{{ $installation['usd_price'] }}</td>
                            <td><button type="button" wire:click="selectInstallation({{ $installation['id'] }})"
                                    class="btn btn-success btn-sm">Seleccionar</button></td>
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
    <!-- /.card-body -->
</div>
<!-- /.card -->
@if (!empty($installationsSelected))
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Instalaciones agregadas:</h3>
        </div>
        <!-- /.card-header -->
        <x-show-list-installations :installationsSelected="$installationsSelected" viewDetail="listInstallations" />
    </div>
    <!-- /.card -->
@endif
