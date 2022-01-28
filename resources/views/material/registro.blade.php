<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            @if ($funcion == 'crear')<h3 class="card-title">Agregar Material</h3>@else<h3 class="card-title">Informacion sobre el Material: {{ $name }}</h3>@endif
        </div>

        <form>

            <div class="card-body">
                <x-form-validation-errors :errors="$errors" />
                <div class="form-group">
                    <label for="code">Código del material</label>
                    <input type="text" class="form-control" id="code" wire:model="code"
                        placeholder="Código del material" required>
                </div>
                <div class="form-group">
                    <label for="name">Nombre del material</label>
                    <input type="text" class="form-control" id="name" wire:model="name"
                        placeholder="Nombre del material" required>
                </div>
                @if ($funcion == 'crear')
                <div class="form-group">
                    <label for="family">Familia</label>
                    <select class="form-control form-control-sm" wire:model="family" wire:change="con" id="family" {{ $disabled }}>
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
                @endif
                <x-material-card :div="$div" :terminal_id="$terminal_id" :termi="$termi" :seal_id="$seal_id"
                    :seli="$seli" :info_term="$info_term" :info_sell="$info_sell" :connector_id="$connector_id"
                    :connect="$connect" :info_con="$info_con" :material_family="$material_family" :rplce="$rplce" :div_tube="$div_tube" />

                @if ($family != 'Cables')
                <div class="form-group">
                    <label for="color">Color</label>
                    <select class="form-control form-control-sm" wire:model="color" id="color">
                        <option selected value="">Selecciona un color</option>
                        <option value="Transparente">Transparente</option>
                        <option value="Negro" class="text-dark">Negro</option>
                        <option value="Blanco">Blanco</option>
                        <option value="Rojo" class="text-danger">Rojo</option>
                        <option value="Azul" class="text-primary">Azul</option>
                        <option value="Amarillo" class="text-warning">Amarillo</option>
                        <option value="Verde" class="text-success">Verde</option>
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" class="form-control" wire:model="description" id="description"
                        cols="30" rows="3"></textarea>
                </div>
                <div class="form-group">
                @if($family != "Cables" && $family != "Tubos")
                    <label for="line">Línea</label>
                    <select class="form-control form-control-sm" wire:model="line" id="line">
                        <option selected>Selecciona una linea</option> 
                        <option value="Bulldog">Bulldog</option>
                        <option value="Ecoseal">Ecoseal</option>
                        <option value="Ecu">Ecu</option>
                        <option value="Fit">Fit</option>
                        <option value="Fastin Faston">Fastin Faston</option>    
                        <option value="Mini">Mini</option>
                        <option value="Sicma">Sicma</option>
                        <option value="Superseal">Superseal</option>
           
                    </select>
                @endif
                </div>
                <div class="form-group">
                    <label for="usage">Uso</label>
                    <select wire:model="usage" id="usage" class="form-control form-control-sm">
                            <option selected>Selecciona un uso</option>
                            <option value="Motos">Motos</option>
                            <option value="General">General</option>
                            <option value="GNC">GNC</option>
                            <option value="Electro">Electro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="stock_min">Stock mínimo</label>
                    <input type="text" class="form-control" id="stock_min" wire:model="stock_min"
                        placeholder="Stock mínimo del material">
                </div>
                <div class="form-group">
                    <label for="stock_max">Stock máximo</label>
                    <input type="text" class="form-control" id="stock_max" wire:model="stock_max"
                        placeholder="Stock máximo del material">
                </div>
                <div class="form-group">
                    <label for="stock">Stock en planta</label>
                    <input type="text" class="form-control" id="stock" wire:model="stock"
                        placeholder="En órdenes de ingresos y egresos" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Imagen</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input wire:model="images" type="file" name="images" class="custom-file-input" multiple>
                            <label class="custom-file-label" for="exampleInputFile">Selecciona las imágenes</label>
                        </div>
                    </div>
                    <div>
                        @if ($funcion == 'crear')
                            <x-img-create-card :images="$images" />
                        @else
                            <x-img-update-card :images="$images" :material="$material" />
                        @endif
                    </div>
                </div>
                <div>
                    
                </div>

                <div class="card-footer">
                    @if ($funcion == 'crear')
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar</button></td>
                    @else
                        <td><button wire:click="editar()" type="button" class="btn btn-primary">Guardar Cambios</button>
                        </td>
                    @endif
                    <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
                </div>
        </form>
    </div>
