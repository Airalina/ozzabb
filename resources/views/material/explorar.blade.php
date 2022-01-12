<div>
    <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"> Material código: {{ $name }} </h3>
    </div>
    <div class="card-body">
        <form>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="form-group">
                        <label for="code">Código del material</label>
                        <input type="text" class="form-control" id="code" wire:model="code"
                            placeholder="Código del material" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Nombre del material</label>
                        <input type="text" class="form-control" id="name" wire:model="name"
                            placeholder="Nombre del material" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="family">Familia</label>
                        <select class="form-control form-control-sm" wire:model="family" wire:change="con" id="family"
                            disabled>
                            <option value="Conectores">conectores</option>
                            <option value="Cables">cables</option>
                            <option value="Terminales">terminales</option>
                            <option value="Sellos">sellos</option>
                            <option value="Tubos">tubos</option>
                            <option value="Accesorios">accesorios</option>
                            <option value="Clips">clips</option>
                        </select>
                    </div>
                    @switch($div)
                    @case("Conectores")
                    <div class="form-group">
                        <label for="terminal">Terminal Asociado</label>
                        <select wire:model="terminal" id="terminal" class="form-control form-control-sm" disabled>
                            @foreach ($info_term as $term)
                            <option value="{{ $term->id }}"> {{ $term->material_info->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="term_size">Tamaño de terminal</label>
                        <input type="text" class="form-control" id="term_size" wire:model="term_size"
                            placeholder="Tamaño de terminal" disabled>
                    </div>
                    <div class="form-group">
                        <label for="seal">Sello Asociado</label>
                        <select wire:model="seal" id="seal" class="form-control form-control-sm" disabled>
                            @foreach ($info_sell as $sell)
                            <option value="{{ $sell->id }}"> {{ $sell->material_info->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="number_of_ways">Cantidad de vías</label>
                        <input type="text" class="form-control" id="number_of_ways" wire:model="number_of_ways"
                            placeholder="Cantidad de vías" readonly>
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="type" id="type" disabled>
                            <option value=" Porta Macho">Porta Macho</option>
                            <option value="Porta Hembra">Porta Hembra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="connector">Contraparte</label>
                        <select wire:model="connector" id="connector" class="form-control form-control-sm" disabled>
                            @foreach ($info_con as $con)
                            <option value="{{ $con->id }}"> {{ $con->material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="watertight">Estanco</label>
                        <select class="form-control form-control-sm" wire:model="watertight" id="watertight" disabled>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lock">Traba secundaria</label>
                        <select class="form-control form-control-sm" wire:model="lock" id="lock" disabled>
                            <option selected value="">Selecciona una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cover">Tapa</label>
                        <select class="form-control form-control-sm" wire:model="cover" id="cover" disabled>
                            <option selected value="">Selecciona una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    @break
                    @case("Cables")
                    <div class="form-group">
                        <label for="section">Sección</label>
                        <input type="text" class="form-control" id="section" wire:model="section"
                            placeholder="Grosor del cable en mm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="base_color">Color base</label>
                        <select class="form-control form-control-sm" wire:model="base_color" id="base_color" disabled>
                            <option value="Negro" class="text-dark">Negro</option>
                            <option value="Blanco">Blanco</option>
                            <option value="Rojo" class="text-danger">Rojo</option>
                            <option value="Azul" class="text-primary">Azul</option>
                            <option value="Amarillo" class="text-warning">Amarillo</option>
                            <option value="Verde" class="text-success">Verde</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="line_color">Color Línea</label>
                        <select class="form-control form-control-sm" wire:model="line_color" id="line_color" disabled>
                            <option value="Negro" class="text-dark">Negro</option>
                            <option value="Blanco">Blanco</option>
                            <option value="Rojo" class="text-danger">Rojo</option>
                            <option value="Azul" class="text-primary">Azul</option>
                            <option value="Amarillo" class="text-warning">Amarillo</option>
                            <option value="Verde" class="text-success">Verde</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="braid_configuration">Configuración de Trenza</label>
                        <select class="form-control form-control-sm" wire:model="braid_configuration"
                            id="braid_configuration" disabled>
                            <option value="16 x 30mm">16 x 30mm</option>
                            <option value="34 x 20mm">34 x 20mm</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="norm">Norma</label>
                        <select class="form-control form-control-sm" wire:model="norm" id="norm" disabled>
                            <option value="Iram 247-5">Iram 247-5</option>
                            <option value="Iram 247-3">Iram 247-3</option>
                            <option value="IR">IR</option>
                            <option value="ID">ID</option>
                            <option value="Blindado">Blindado</option>
                            <option value="Multifilar">Multifilar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="number_of_unipolar">Cantidad de unipolares</label>
                        <input type="text" class="form-control" id="number_of_unipolar" wire:model="number_of_unipolar"
                            placeholder="Cantidad de unipolares" readonly>
                    </div>
                    <div class="form-group">
                        <label for="mesh_type">Tipo de malla</label>
                        <input type="text" class="form-control" id="mesh_type" wire:model="mesh_type"
                            placeholder="Tipo de malla" readonly>
                    </div>
                    <div class="form-group">
                        <label for="operating_temperature">Temperatura de Servicio</label>
                        <input type="text" class="form-control" id="operating_temperature"
                            wire:model="operating_temperature" placeholder="Temperatura en grados Celsius" readonly>
                    </div>
                    @break
                    @case("Terminales")
                    <div class="form-group">
                        <label for="size">Tamaño</label>
                        <input type="text" class="form-control" id="size" wire:model="size" placeholder="Tamaño en mm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="minimum_section">Sección mínima agrafado</label>
                        <input type="text" class="form-control" id="minimum_section" wire:model="minimum_section"
                            placeholder="Sección mínima" readonly>
                    </div>
                    <div class="form-group">
                        <label for="maximum_section">Sección máxima agrafado</label>
                        <input type="text" class="form-control" id="maximum_section" wire:model="maximum_section"
                            placeholder="Sección máxima" readonly>
                    </div>
                    <div class="form-group">
                        <label for="term_material">Material</label>
                        <select class="form-control form-control-sm" wire:model="term_material" id="term_material" disabled>
                            <option value="Latón">Latón</option>
                            <option value="Estañado">Estañado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="term_type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="term_type" id="term_type" disabled>
                            <option value="Macho">Macho</option>
                            <option value="Hembra">Hembra</option>
                        </select>
                    </div>
                    @break
                    @case("Sellos")
                    <div class="form-group">
                        <label for="minimum_diameter">Diámetro mínimo de Cable</label>
                        <input type="text" class="form-control" id="minimum_diameter" wire:model="minimum_diameter"
                            placeholder="Diámetro mínimo de Cable" readonly>
                    </div>
                    <div class="form-group">
                        <label for="maximum_diameter">Diámetro máximo de Cable</label>
                        <input type="text" class="form-control" id="maximum_diameter" wire:model="maximum_diameter"
                            placeholder="Diámetro máximo de Cable" readonly>
                    </div>
                    <div class="form-group">
                        <label for="seal_type">Tipo</label>
                        <input type="text" class="form-control" id="seal_type" wire:model="seal_type"
                            placeholder="Tipo de sello" readonly>
                    </div>
                    @break
                    @case("Tubos")
                    <div class="form-group">
                        <label for="tube_type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="tube_type" id="tube_type" disabled>
                            <option value="Corrugado">Corrugado</option>
                            <option value="Termocontraible">Termocontraible</option>
                            <option value="PVC">PVC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tube_diameter">Diámetro</label>
                        <input type="text" class="form-control" id="tube_diameter" wire:model="tube_diameter"
                            placeholder="Diámetro del tubo en milímetros" readonly>
                    </div>
                    <div class="form-group">
                        <label for="wall_thickness">Espesor de pared</label>
                        <input type="text" class="form-control" id="wall_thickness" wire:model="wall_thickness"
                            placeholder="Grosor de la pared del tubo en mm" readonly>
                    </div>
                    @if($tube_type == "Termocontraible")
                    <div class="form-group">
                        <label for="contracted_diameter">Diámetro Contraído</label>
                        <input type="text" class="form-control" id="contracted_diameter"
                            wire:model="contracted_diameter" placeholder="Diámetro del tubo una vez contraído" readonly>
                    </div>
                    <div class="form-group">
                        <label for="minimum_temperature">Temperatura mínima de Servicio</label>
                        <input type="text" class="form-control" id="minimum_temperature"
                            wire:model="minimum_temperature" placeholder="Temperatura mínima de Servicio" readonly>
                    </div>
                    <div class="form-group">
                        <label for="maximum_temperature">Temperatura máxima de Servicio</label>
                        <input type="text" class="form-control" id="maximum_temperature"
                            wire:model="maximum_temperature" placeholder="Temperatura máxima de Servicio" readonly>
                    </div>
                    @endif
                    @break
                    @case("Accesorios")
                    <div class="form-group">
                        <label for="accesory_type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="accesory_type" id="accesory_type" disabled>
                            <option value="Tapa de conector">Tapa de conector</option>
                            <option value="Fusible">Fusible</option>
                            <option value="Relay">Relay</option>
                            <option value="Pasante de Goma">Pasante de Goma</option>
                        </select>
                    </div>
                    @break
                    @case("Clips")
                    <div class="form-group">
                        <label for="clip_type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="clip_type" id="clip_type" disabled>
                            <option value="Clip">Clip</option>
                            <option value="Precinto">Precinto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="long">Largo</label>
                        <input type="text" class="form-control" id="long" wire:model="long" placeholder="Largo en mm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="width">Ancho</label>
                        <input type="text" class="form-control" id="width" wire:model="width" placeholder="Ancho en mm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="hole_diameter">Diámetro del Orificio</label>
                        <input type="text" class="form-control" id="hole_diameter" wire:model="hole_diameter"
                            placeholder="Diámetro del Orificio" readonly>
                    </div>
                    @break

                    @endswitch
                    @if ($material_family)
                    <div class="form-group">
                        <label for="replace">Reemplazo</label>
                        <select class="form-control form-control-sm" wire:model="replace" id="replace" disabled>
                            @foreach ($material_family as $rep)
                            <option value="{{ $rep->id }}"> {{ $rep->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="color">Color</label>
                        <select class="form-control form-control-sm" wire:model="color" id="color" disabled>
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
                        <textarea name="description" class="form-control" wire:model="description" id="description"
                            cols="30" rows="3" readonly></textarea>
                    </div>
                    <div class="form-group">
                        @if($family != "Cables")
                        <label for="line">Línea</label>
                        <select class="form-control form-control-sm" wire:model="line" id="line" disabled>
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
                        <select wire:model="usage" id="usage" class="form-control form-control-sm" disabled>
                            <option value="Motos">Motos</option>
                            <option value="GNC">GNC</option>
                            <option value="Electro">Electro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stock_min">Stock mínimo</label>
                        <input type="text" class="form-control" id="stock_min" wire:model="stock_min"
                            placeholder="Stock mínimo del material" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stock_max">Stock máximo</label>
                        <input type="text" class="form-control" id="stock_max" wire:model="stock_max"
                            placeholder="Stock máximo del material" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock en planta</label>
                        <input type="text" class="form-control" id="stock" wire:model="stock"
                            placeholder="Stock en planta" readonly>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de precios del material</h3>
                <div class="card-tools">
                    @if (auth()->user()->can('storematerial', auth()->user()))
                    <div>
                        <button wire:click="agregamat({{ $material->id }})" type="button" class="btn btn-info btn-sm">Agregar
                            Precio</button>
                    </div>
                    @endif
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Proveedor</th>
                            <th>Presentación</th>
                            <th>Fecha</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($provider_prices)
                        @forelse($provider_prices as $provider_price)
                        <tr>
                            <td>{{ $provider_price->material->code }}</td>
                            <td>{{ $provider_price->material->name }}</td>
                            <td>{{ $provider_price->provider->name }}</td>
                            <td>{{ $provider_price->unit }} {{ $provider_price->presentation }}</td>
                            <td>{{ $provider_price->created_at->format('d/m/Y') }}</td>
                            <td>{{ $provider_price->usd_price }}</td>

                            @if (auth()->user()->can('updatematerial', auth()->user()))
                            <td><button wire:click="updatemat({{ $provider_price->id }})" type="button"
                                    class="btn btn-success btn-sm">Actualizar</button></td>
                            @endif
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="4" class="py-3 italic">No hay información</td>
                        </tr>
                        @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>