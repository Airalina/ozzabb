<div class="card card-primary">
    <div class="card-header">
        @if ($funcion == 'crearmat')<h3 class="card-title">Agregar Material</h3>@else<h3 class="card-title">Informacion sobre el material: {{ $name }}</h3>@endif

    </div>

    <form>
        <div class="card-body">
            <h5>Datos del material</h5>
            <br>
            <x-form-validation-errors :errors="$errors"/>

                @if ($addMaterial)
                    <div class="form-group">
                        <label for="code">Código del material</label>
                        <input type="text" class="form-control" id="code" wire:model="code"
                            placeholder="Código del material" required>
                    </div>
                    <div class="form-group">
                        <label for="name_material">Nombre del material</label>
                        <input type="text" class="form-control" id="name_material" wire:model="name_material"
                            placeholder="Nombre del material" required>
                    </div>
                    <div class="form-group">
                        <label for="family">Familia</label>
                        <select class="form-control form-control-sm" wire:model="family" wire:change="con" id="family">
                            <option selected value="">Selecciona una familia</option>
                            <option value="Conectores">conectores</option>
                            <option value="Cables">cables</option>
                            <option value="Terminales">terminales</option>
                            <option value="Sellos">sellos</option>
                        </select>
                    </div>
                    <div class="form-group" id="div">
                    </div>
        
                    <x-material-card :div="$div"
                        :info_term="$info_term" :info_sell="$info_sell" :info_con="$info_con" :material_family="$material_family" :rplce=null :terminal_id=null :seal_id=null  :connector_id=null  />

                    <div class="form-group">
                        <label for="color">Color</label>
                        <select class="form-control form-control-sm" wire:model="color" id="color">
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
                        <label for="line">Línea</label>
                        <select wire:model="line" id="line" class="form-control form-control-sm">
                              <x-line-card :line_id="$line_id" :info_line="$info_line" />
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="usage">Uso</label>
                        <select wire:model="usage" id="usage" class="form-control form-control-sm">
                             <x-usage-card :usage_id="$usage_id" :info_usage="$info_usage" />
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stock_min">Stock mínimo</label>
                        <input type="text" class="form-control" id="stock_min" wire:model="stock_min"
                            placeholder="Stock mínimo del material">
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock en planta</label>
                        <input type="text" class="form-control" id="stock" wire:model="stock"
                            placeholder="Stock en planta">
                    </div>
                @else
                    <div class="form-group">
                        <button wire:click="addMaterial()" type="button" class="btn btn-info">Añadir material</button>
                    </div>
                    <div class="form-group">
                        <select wire:model="material" id="material" class="form-control form-control-sm">
                            @if ($mat_n != null)
                                <option value="{{ $mat_n->id }}" selected>{{ $mat_n->code }} - {{ $mat_n->name }}
                                </option>
                            @else
                                <option selected>Seleccione un material</option>
                            @endif
                            @foreach ($info_mat as $mat)
                                @if ($mat_n != null)
                                    @if ($mat_n->id === $mat->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                                <option value="{{ $mat->id }}">{{ $mat->code }} - {{ $mat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="form-group">
                    <label for="amount">Cantidad</label>
                    <input class="form-control form-control-sm" type="string" id="amount" wire:model="amount"
                        placeholder="Ingrese la cantidad">
                </div>
                <div class="form-group">
                    <label for="unit">Unidad de presentación</label>
                    <div class="d-flex">
                        <input class="form-control form-control-sm" type="string" id="unit" wire:model="unit"
                            placeholder="Ingrese las unidades">
                        <select class="form-control form-control-sm" wire:model="presentation" id="presentation">
                            <option selected value="">Selecciona una medida</option>
                            <option value="mm">Milímetros</option>
                            <option value="und">Unidades</option>
                            <option value="cajas">Cajas</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="usd_price">Precio U$D</label>
                    <input class="form-control form-control-sm" type="text" id="usd_price" wire:model="usd_price"
                        placeholder="Ingrese el precio U$D">
                </div>
                <div class="form-group">
                    <label for="ars_price">Precio AR$</label>
                    <input class="form-control form-control-sm" type="text" id="ars_price" wire:model="ars_price"
                        placeholder="Ingrese el precio AR$">
                </div>
        </div>
        <div class="card-footer">
            @if ($funcion == 'crearmat')
                <td><button wire:click="storemat({{ $provider }})" type="button"
                        class="btn btn-primary">Guardar</button></td>

            @else
                <td><button wire:click="editarmat()" type="button" class="btn btn-primary">Guardar Cambios</button></td>
            @endif

            <td><button wire:click="backmat()" type="button" class="btn btn-primary">Cancelar</button></td>
        </div>
    </form>


</div>
