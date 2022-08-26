<div class="col">
    <div class="card mb-3 border-dark">
        <div class="card-header">
            @if ($addMaterial)
                <div class="form-group">
                    <button wire:click="addMaterial()" type="button" class="btn btn-info btn-sm">Agregar
                        material nuevo</button>
                </div>

                <h3 class="card-title">Seleccione material a ser agregado:</h3>
                <br>
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input wire:model="searchmaterials" type="text" class="form-control form-control-xs float-right"
                        placeholder="Buscar material...">
                </div>

                <!-- /.card-header -->
                @if ($searchmaterials != '')
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Nombre</th>
                                    <th style="text-align: center">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materials as $material)
                                    <tr>
                                        <td style="text-align: center">{{ $material->code }}
                                        </td>
                                        <td style="text-align: center">
                                            {{ $material->name }}</td>
                                        <td style="text-align: center"><button type="button"
                                                wire:click="selectmaterial({{ $material->id }})"
                                                class="btn btn-success btn-sm">Agregar</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="4" class="py-3 italic">No hay
                                            información
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
            @if (isset($materialSelected))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Material agregado:</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Nombre</th>
                                    <th style="text-align: center">Familia</th>
                                    <th style="text-align: center">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">{{ $materialSelected->code }}</td>
                                    <td style="text-align: center">{{ $materialSelected->name }}</td>
                                    <td style="text-align: center">{{ $materialSelected->family }}</td>
                                    <td style="text-align: center"><button type="button" wire:click="downmaterial"
                                            class="btn btn-danger btn-sm">Quitar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            @endif

            <x-form-create-price />
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

</div>
