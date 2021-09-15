<div>
    <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title">Materiales Registrados</h3>
            <div class="card-tools">
                @if (auth()->user()->can('storematerial', auth()->user()))
                    <div>
                        <button wire:click="funcion()" type="button" class="btn btn-info">Agregar Material</button>
                    </div>
                @endif
                <div class="input-group input-group-sm" style="width: 135px;">
                    <input wire:model="search" type="text" class="form-control float-right"
                        placeholder="Buscar Materiales">
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-head text-nowrap">
                <div class="form-group" data-select2-id="45">
                    <label>Ordenar por</label>
                    <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="47" value="id">Id</option>
                        <option data-select2-id="48" value="name">Nombre</option>
                        <option data-select2-id="49" value="family">Familia</option>
                        <option data-select2-id="50" value="color">Color</option>
                        <option data-select2-id="51" value="line_id">Linea</option>
                        <option data-select2-id="52" value="usage_id">Uso</option>
                        <option data-select2-id="53" value="replace_id">Puesto de contacto</option>
                        <option data-select2-id="54" value="stock_min">Stock Min.</option>
                        <option data-select2-id="55" value="stock_min">Stock Max.</option>
                        <option data-select2-id="56" value="stock">Stock</option>
                    </select>
                </div>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Familia</th>
                        <th>Color</th>
                        <th>Linea</th>
                        <th>Uso</th>
                        <th>Remplazo</th>
                        <th>Stock Min.</th>
                        <th>Stock Max.</th>
                        <th>Stock</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($materials as $material)

                        <tr class="registros">
                            <td>{{ $material->id }} </td>
                            <td>{{ $material->code }} </td>
                            <td>{{ $material->name }} </td>
                            <td>{{ $material->family }} </td>
                            <td>{{ $material->color }} </td>
                            <td>
                                @if ($material->line != null)
                                    {{ $material->line->name }}
                                @endif
                            </td>
                            <td>
                                @if ($material->usage != null)
                                    {{ $material->usage->name }}
                                @endif
                            </td>
                            <td>
                                @if ($material->material != null)
                                    {{ $material->material->name }}
                                @endif
                            </td>
                            <td>{{ $material->stock_min }} </td>
                            <td>{{ $material->stock_max }} </td>
                            <td>{{ $material->stock }} </td>

                            <td>
                                <button type="button" wire:click="explorar({{ $material->id }})"
                                    class="btn btn-primary btn-xs"><i class="fas fa-file-alt"></i> Ver</button>
                                @if (auth()->user()->can('updatematerial', auth()->user()))
                                    <button wire:click="update({{ $material->id }})" type="button"
                                        class="btn btn-success btn-xs">Actualizar</button>
                                @endif
                                @if (auth()->user()->can('deletematerial', auth()->user()))
                                    <button wire:click="destruir({{ $material->id }})" type="button"
                                        class="btn btn-danger btn-xs">Borrar</button>
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
        </div>
        <!-- /.card-body -->
    </div>
</div>
