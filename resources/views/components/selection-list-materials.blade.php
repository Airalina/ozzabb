<div class="card">
    <div class="card-header">
        <h3 class="card-title">Seleccione material a ser agregado:</h3>
        <br>
        <div class="input-group input-group-sm" style="width: 150px;">
            <input wire:model="searchMaterials" type="text" class="form-control form-control-xs float-right"
                placeholder="Buscar material...">
        </div>
    </div>
    <!-- /.card-header -->
    @if ($searchMaterials != '')
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align: center">Código</th>
                        <th style="text-align: center">Descripción</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $material)
                        <tr>
                            <td style="text-align: center">{{ $material['code'] }}</td>
                            <td style="text-align: center">{{ $material['description'] }}</td>
                            <td><button type="button" wire:click="selectMaterial({{ $material['id'] }})"
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
@if (!empty($materialsSelected))
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Materiales agregados:</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align: center">Codigo</th>
                        <th style="text-align: center">Descripción</th>
                        <th style="text-align: center">Cantidad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materialsSelected as $materialSelected)
                        <tr>
                            <td style="text-align: center">{{ $materialSelected['code'] }}</td>
                            <td style="text-align: center">{{ $materialSelected['description'] }}</td>
                            <td style="text-align: center">{{ $materialSelected['amount'] }}</td>
                            <td style="text-align: center"><button type="button"
                                    wire:click="downMaterial({{ $materialSelected['id'] }})"
                                    class="btn btn-danger btn-sm">Quitar</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endif
