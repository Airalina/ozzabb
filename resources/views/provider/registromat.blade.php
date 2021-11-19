<div>
    <button wire:click="backmat()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>

<div class="col-md-6">

    <div class="card card-primary">
        <div class="card-header">
            @if ($funcion == 'crearmat')<h3 class="card-title">Agregar Material</h3>@else<h3 class="card-title">
                Información sobre el material: {{ $material_name }}</h3>@endif
        </div>
        <div class="card-body">
            <h5>Datos del material</h5>
            <br>
            <x-form-validation-errors :errors="$errors" />
            <form>
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
                                <input wire:model="searchmateriales" type="text"
                                    class="form-control form-control-xs float-right" placeholder="Buscar material...">
                            </div>

                            <!-- /.card-header -->
                            @if ($searchmateriales != '')
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
                                        @forelse($materiales as $material)
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
                            @if(isset($material_new))
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
                                                <td style="text-align: center">{{ $material_new->code }}</td>
                                                <td style="text-align: center">{{ $material_new->name }}</td>
                                                <td style="text-align: center">{{ $material_new->family }}</td>
                                                <td style="text-align: center"><button type="button"
                                                        wire:click="downmaterial"
                                                        class="btn btn-danger btn-sm">Quitar</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="amount">Cantidad</label>
                                <input class="form-control form-control-sm" type="string" id="amount"
                                    wire:model="amount" placeholder="Ingrese la cantidad">
                            </div>
                            <div class="form-group">
                                <label for="unit">Unidad de presentación</label>
                                <div class="d-flex">
                                    <input class="form-control form-control-sm" type="string" id="unit"
                                        wire:model="unit" placeholder="Ingrese las unidades">
                                    <select class="form-control form-control-sm" wire:model="presentation"
                                        id="presentation">
                                        <option selected value="">Selecciona una medida</option>
                                        <option value="mm">Milímetros</option>
                                        <option value="und">Unidades</option>
                                        <option value="cajas">Cajas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usd_price">Precio U$D</label>
                                <input class="form-control form-control-sm" type="text" id="usd_price"
                                    wire:model="usd_price" placeholder="Ingrese el precio U$D">
                            </div>
                            <div class="form-group">
                                <label for="ars_price">Precio AR$</label>
                                <input class="form-control form-control-sm" type="text" id="ars_price"
                                    wire:model="ars_price" placeholder="Ingrese el precio AR$">
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                   
                </div>
                <div class="card-footer">
                    @if ($funcion == 'crearmat')
                    <td><button wire:click="storemat({{ $provider }})" type="button"
                            class="btn btn-primary">Guardar</button></td>

                    @else
                    <td><button wire:click="editarmat()" type="button" class="btn btn-primary">Guardar Cambios</button>
                    </td>
                    @endif

                    <td><button wire:click="backmat()" type="button" class="btn btn-primary">Cancelar</button></td>
                </div>
            </form>
        </div>

    </div>
    <div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form wire.submit.prevent="addproviderprice">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <x-form-validation-errors :errors="$errors" />
                        <div class="form-group">
                            <label for="code">Código del material</label>
                            <input type="text" class="form-control  form-control-sm" id="code" wire:model.defer="code"
                                placeholder="Código del material" required>
                        </div>
                        <div class="form-group">
                            <label for="name_material">Nombre del material</label>
                            <input type="text" class="form-control  form-control-sm" id="name_material"
                                wire:model.defer="name_material" placeholder="Nombre del material" required>
                        </div>
                        <div class="form-group">
                            <label for="family">Familia</label>
                            <select class="form-control form-control-sm" wire:model.defer="family" wire:change="con"
                                id="family">
                                <option selected value="">Selecciona una familia</option>
                                <option value="Conectores">conectores</option>
                                <option value="Cables">cables</option>
                                <option value="Terminales">terminales</option>
                                <option value="Sellos">sellos</option>
                                <option value="Tubos">tubos</option>
                                <option value="Accesorios">accesorios</option>
                                <option value="Clips">clips</option>
                            </select>
                        </div>
                        <div class="form-group" id="div">
                        </div>

                        <x-material-card :div="$div" :info_term="$info_term" :info_sell="$info_sell"
                            :info_con="$info_con" :material_family="$material_family" :rplce=null :terminal_id=null
                            :seal_id=null :connector_id=null />

                        <div class="form-group">
                            <label for="color">Color</label>
                            <select class="form-control form-control-sm" wire:model.defer="color" id="color">
                                <option selected value="">Selecciona un color</option>
                                <option value="Negro" class="text-dark">Negro</option>
                                <option value="Blanco">Blanco</option>
                                <option value="Rojo" class="text-danger">Rojo</option>
                                <option value="Azul" class="text-primary">Azul</option>
                                <option value="Amarillo" class="text-warning">Amarillo</option>
                                <option value="Verde" class="text-success">Verde</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" class="form-control" wire:model.defer="description" id="description"
                                cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            @if ($family != 'Cables')
                            <label for="line">Línea</label>
                            <select class="form-control form-control-sm" wire:model.defer="line" id="line">
                                <option selected>Selecciona una linea</option>
                                <option value="Superseal">Superseal</option>
                                <option value="Mini">Mini</option>
                                <option value="Fit">Fit</option>
                                <option value="Bulldog">Bulldog</option>
                                <option value="Econoseal">Econoseal</option>
                                <option value="Eco">Eco</option>
                            </select>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="usage">Uso</label>
                            <select wire:model.defer="usage" id="usage" class="form-control form-control-sm">
                                <option selected>Selecciona un uso</option>
                                <option value="Motos">Motos</option>
                                <option value="GNC">GNC</option>
                                <option value="Electro">Electro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stock_min">Stock mínimo</label>
                            <input type="text" class="form-control  form-control-sm" id="stock_min"
                                wire:model.defer="stock_min" placeholder="Stock mínimo del material">

                        </div>
                        <div class="form-group">
                            <label for="stock">Stock máximo</label>
                            <input type="text" class="form-control form-control-sm" id="stock_max"
                                wire:model.defer="stock_max" placeholder="Stock máximo del material">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock en planta</label>
                            <input type="text" class="form-control" id="stock" wire:model.defer="stock"
                                placeholder="En órdenes de ingresos y egresos" readonly>
                        </div>
                        <div class="modal-footer">
                            @if ($funcion == 'crearmat')
                            <button wire:click.prevent="addmaterialprice()" type="submit"
                                class="btn btn-primary">Guardar</button>
                            @else
                            <button wire:click.prevent="addmaterialprice()" type="submit" class="btn btn-primary">Guardar
                                Cambios</button>
                            @endif
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>