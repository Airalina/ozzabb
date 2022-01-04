<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Materiales Registrados</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input wire:model="search" type="text" class="form-control float-right"
                        placeholder="Buscar Material...">
                </div>
            </div>

        </div>
        <div class="card-header">
            <div>
                <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px"
                    type="number" min="1" wire:model="paginas" class="form-control">
            </div>
            <div class="card-tools">
                @if (auth()->user()->can('storematerial', auth()->user()))
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <button wire:click="funcion()" type="button" class="btn btn-info btn-sm">Agregar
                            Material</button>
                    </div>
                @endif
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-head table-sm">
                <div class="form-group" data-select2-id="45">
                    <label>Ordenar por</label>
                    <select wire:model="order" class="form-control select2bs4 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option data-select2-id="47" value="id">Id</option>
                        <option data-select2-id="48" value="name">Nombre</option>
                        <option data-select2-id="49" value="family">Familia</option>
                        <option data-select2-id="50" value="color">Color</option>
                        <option data-select2-id="51" value="line">Linea</option>
                        <option data-select2-id="52" value="usage">Uso</option>
                        <option data-select2-id="53" value="replace_id">Puesto de contacto</option>
                        <option data-select2-id="54" value="stock_min">Stock Min.</option>
                        <option data-select2-id="55" value="stock_min">Stock Max.</option>
                        <option data-select2-id="56" value="stock">Stock</option>
                    </select>
                </div>
                <thead>
                    <tr>
                        <th style="text-align: center">ID</th>
                        <th style="text-align: center">Codigo</th>
                        <th style="text-align: center">Nombre</th>
                        <th style="text-align: center">Familia</th>
                        <th style="text-align: center">Color</th>
                        <th style="text-align: center">Linea</th>
                        <th style="text-align: center">Uso</th>
                        <th style="text-align: center">Remplazo</th>
                        <th style="text-align: center">Stock Min.</th>
                        <th style="text-align: center">Stock Max.</th>
                        <th style="text-align: center">Stock</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($materials as $material)

                        <tr class="registros">
                            <td style="text-align: center">{{ $material->id }} </td>
                            <td style="text-align: center">{{ $material->code }} </td>
                            <td style="text-align: center">{{ $material->name }} </td>
                            <td style="text-align: center">{{ $material->family }} </td>
                            <td style="text-align: center">{{ $material->color }} </td>
                            <td style="text-align: center">
                                @if ($material->line != null)
                                    {{ $material->line }}
                                @endif
                            </td>
                            <td style="text-align: center">
                                @if ($material->usage != null)
                                    {{ $material->usage }}
                                @endif
                            </td>
                            <td style="text-align: center">
                                @if ($material->material != null)
                                    {{ $material->material->name }}
                                @endif
                            </td>
                            <td style="text-align: center">{{ $material->stock_min }} </td>
                            <td style="text-align: center">{{ $material->stock_max }} </td>
                            <td style="text-align: center">{{ $material->stock }} </td>

                            <td style="text-align: center">
                                <button type="button" wire:click="explorar({{ $material->id }})"
                                    class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                                @if (auth()->user()->can('updatematerial', auth()->user()))
                                    <button wire:click="update({{ $material->id }})" type="button"
                                        class="btn btn-success btn-sm">Actualizar</button>
                                @endif
                                @if (auth()->user()->can('deletematerial', auth()->user()))
                                    <button wire:click="destruir({{ $material->id }})" type="button"
                                        class="btn btn-danger btn-sm">Borrar</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="11" class="py-3 italic">No hay información</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $materials->links() }}
        </div>
        <!-- /.card-body -->
        @include('borrar')
    </div>
</div>
