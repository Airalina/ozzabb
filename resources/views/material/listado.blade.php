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
                        <button wire:click="create()" type="button" class="btn btn-info btn-sm">Agregar
                            Material</button>
                    </div>
                @endif
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-head table-sm">
                <div class="form-group">
                    <label>Ordenar por</label>
                    <select wire:model="order" class="form-control" style="width: 100%;" tabindex="-1">
                        <option value="code">Código</option>
                        <option value="name">Nombre</option>
                        <option value="family">Familia</option>
                        <option value="color">Color</option>
                        <option value="line">Linea</option>
                        <option value="usage">Uso</option>
                        <option value="stock_min">Stock Min.</option>
                        <option value="stock_max">Stock Max.</option>
                        <option value="stock">Stock</option>
                    </select>
                </div>
                <thead>
                    <tr>
                        <th style="text-align: center">Código</th>
                        <th style="text-align: center">Nombre</th>
                        <th style="text-align: center">Familia</th>
                        <th style="text-align: center">Color</th>
                        <th style="text-align: center">Linea</th>
                        <th style="text-align: center">Uso</th>
                        <th style="text-align: center">Remplazo</th>
                        <th style="text-align: center">Stock Min.</th>
                        <th style="text-align: center">Stock Max.</th>
                        <th style="text-align: center">Stock</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $material)
                        <tr class="registros">
                            <td style="text-align: center">{{ $material->code }} </td>
                            <td style="text-align: center">{{ $material->name }} </td>
                            <td style="text-align: center">{{ $material->family }} </td>
                            <td style="text-align: center">
                                {{ $material->family != 'Cables' ? $material->color : $material->cable->base_color . ' ' . $material->cable->line_color }}
                            </td>
                            <td style="text-align: center">
                                {{ $material->line != 'Ecoseal' ? $material->line : 'Econoseal' }}
                            </td>
                            <td style="text-align: center">
                                {{ $material->usage }}
                            </td>
                            <td style="text-align: center">
                                {{ $material->replace ? $material->replace->code . ' ' . $material->replace->name : ' ' }}
                            </td>
                            <td style="text-align: center">{{ $material->stock_min }} </td>
                            <td style="text-align: center">{{ $material->stock_max }} </td>
                            <td style="text-align: center">{{ $material->stock }} </td>
                            <td style="text-align: center">
                                <button type="button" wire:click="explorar({{ $material->id }})"
                                    class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> Ver</button>
                                @if (auth()->user()->can('updatematerial', auth()->user()))
                                    <button wire:click="edit({{ $material->id }})" type="button"
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
                            <td colspan="11" class="py-3 italic">{{ !empty($search) ? 'No hay materiales que coincidan con el código buscado' : 'No hay información' }}</td>
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
