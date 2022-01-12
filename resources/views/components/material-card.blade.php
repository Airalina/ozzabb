            @switch($div)
                @case("Conectores")
                    <div class="form-group">
                        <label for="terminal">Terminal Asociado</label>
                        <select wire:model="terminal" wire:change="size" id="terminal" class="form-control form-control-sm">

                            @if ($terminalId != null)
                                <option value="{{ $termi->id }}" selected>{{ $termi->material_info->name }}</option>
                            @else
                                <option selected value="">Seleccione un terminal</option>
                            @endif

                            @foreach ($infoTerm as $term)
                                @if ($terminalId != null)
                                    @if ($terminalId === $term->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
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

                        <select wire:model="seal" id="seal" class="form-control form-control-sm">
                            @if ($sealId != null)
                                <option value="{{ $seli->id }}" selected>{{ $seli->material_info->name }}</option>
                            @else
                                <option selected>Seleccione un sello</option>
                            @endif
                            @foreach ($infoSell as $sell)
                                @if ($sealId != null)
                                    @if ($sealId === $sell->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                                <option value="{{ $sell->id }}"> {{ $sell->material_info->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="number_of_ways">Cantidad de vías</label>
                        <input type="text" class="form-control" id="number_of_ways" wire:model="number_of_ways"
                            placeholder="Cantidad de vías">
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="type" id="type">
                            <option selected value="">Selecciona un tipo</option>
                            <option value="Porta Macho">Porta Macho</option>
                            <option value="Porta Hembra">Porta Hembra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="connector">Contraparte</label>
                        <select wire:model="connector" id="connector" class="form-control form-control-sm">

                            @if ($connectorId != null)
                                <option value="{{ $connect->id }}" selected>{{ $connect->material->name }}</option>
                            @else
                                <option selected>Seleccione una contraparte</option>
                            @endif
                            @foreach ($infoCon as $con)
                                @if ($connectorId != null)
                                    @if ($connectorId === $con->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                                <option value="{{ $con->id }}"> {{ $con->material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="watertight">Estanco</label>
                        <select class="form-control form-control-sm" wire:model="watertight" id="watertight">
                            <option selected value="">Selecione una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lock">Traba secundaria</label>
                        <select class="form-control form-control-sm" wire:model="lock" id="lock">
                            <option selected value="">Selecciona una opción</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cover">Tapa</label>
                        <select class="form-control form-control-sm" wire:model="cover" id="cover">
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
                            placeholder="Grosor del cable en mm">
                    </div>
                    <div class="form-group">
                        <label for="base_color">Color base</label>
                        <select class="form-control form-control-sm" wire:model="base_color" id="base_color">
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
                        <label for="line_color">Color Línea</label>
                        <select class="form-control form-control-sm" wire:model="line_color" id="line_color">
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
                        <label for="braid_configuration">Configuración de Trenza</label>
                        <select class="form-control form-control-sm" wire:model="braid_configuration"
                            id="braid_configuration">
                            <option selected value="">Selecciona una configuración</option>
                            <option value="16 x 30mm">16 x 30mm</option>
                            <option value="34 x 20mm">34 x 20mm</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="norm">Norma</label>
                        <select class="form-control form-control-sm" wire:model="norm" id="norm">
                            <option selected value="">Selecciona una norma</option>
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
                            placeholder="Cantidad de unipolares">
                    </div>
                    <div class="form-group">
                        <label for="mesh_type">Tipo de malla</label>
                        <input type="text" class="form-control" id="mesh_type" wire:model="mesh_type"
                            placeholder="Tipo de malla">
                    </div>
                    <div class="form-group">
                        <label for="operating_temperature">Temperatura de Servicio</label>
                        <input type="text" class="form-control" id="operating_temperature" wire:model="operating_temperature"
                            placeholder="Temperatura en grados Celsius">
                    </div>
                @break
                @case("Terminales")
                    <div class="form-group">
                        <label for="size">Tamaño</label>
                        <input type="text" class="form-control" id="size" wire:model="size" placeholder="Tamaño en mm">
                    </div>
                    <div class="form-group">
                        <label for="minimum_section">Sección mínima agrafado</label>
                        <input type="text" class="form-control" id="minimum_section" wire:model="minimum_section"
                            placeholder="Sección mínima">
                    </div>
                    <div class="form-group">
                        <label for="maximum_section">Sección máxima agrafado</label>
                        <input type="text" class="form-control" id="maximum_section" wire:model="maximum_section"
                            placeholder="Sección máxima">
                    </div>
                    <div class="form-group">
                        <label for="term_material">Material</label>
                        <select class="form-control form-control-sm" wire:model="term_material" id="term_material">
                            <option selected value="">Selecciona un material</option>
                            <option value="Latón">Latón</option>
                            <option value="Estañado">Estañado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="term_type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="term_type" id="term_type">
                            <option selected value="">Selecciona un tipo</option>
                            <option value="Macho">Macho</option>
                            <option value="Hembra">Hembra</option>
                        </select>
                    </div>
                @break
                @case("Sellos")
                    <div class="form-group">
                        <label for="minimum_diameter">Diámetro mínimo de Cable</label>
                        <input type="text" class="form-control" id="minimum_diameter" wire:model="minimum_diameter"
                            placeholder="Diámetro mínimo de Sello">
                    </div>
                    <div class="form-group">
                        <label for="maximum_diameter">Diámetro máximo de Cable</label>
                        <input type="text" class="form-control" id="maximum_diameter" wire:model="maximum_diameter"
                            placeholder="Diámetro máximo de Cable">
                    </div>
                    <div class="form-group">
                        <label for="seal_type">Tipo</label>
                        <input type="text" class="form-control" id="seal_type" wire:model="seal_type"
                            placeholder="Tipo de sello">
                    </div>
                @break
                @case("Tubos")
                    <div class="form-group">
                        <label for="tube_type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="tube_type" id="tube_type" wire:change="select_type">
                            <option selected value="">Selecciona un tipo</option>
                            <option value="Corrugado">Corrugado</option>
                            <option value="Termocontraible">Termocontraible</option>
                            <option value="PVC">PVC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tube_diameter">Diámetro</label>
                        <input type="text" class="form-control" id="tube_diameter" wire:model="tube_diameter"
                            placeholder="Diámetro del tubo en milímetros">
                    </div>
                    <div class="form-group">
                        <label for="wall_thickness">Espesor de pared</label>
                        <input type="text" class="form-control" id="wall_thickness" wire:model="wall_thickness"
                            placeholder="Grosor de la pared del tubo en mm">
                    </div>
                     @if ($divTube)
                        <div class="form-group">
                            <label for="contracted_diameter">Diámetro Contraído</label>
                            <input type="text" class="form-control" id="contracted_diameter" wire:model="contracted_diameter"
                                placeholder="Diámetro del tubo una vez contraído">
                        </div>
                        <div class="form-group">
                            <label for="minimum_temperature">Temperatura mínima de Servicio</label>
                            <input type="text" class="form-control" id="minimum_temperature" wire:model="minimum_temperature"
                                placeholder="Temperatura mínima de Servicio">
                        </div>
                        <div class="form-group">
                            <label for="maximum_temperature">Temperatura máxima de Servicio</label>
                            <input type="text" class="form-control" id="maximum_temperature" wire:model="maximum_temperature"
                                placeholder="Temperatura máxima de Servicio">
                        </div>
                     @endif
                @break
                @case("Accesorios")
                    <div class="form-group">
                        <label for="accesory_type">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="accesory_type" id="accesory_type">
                            <option selected value="">Selecciona un tipo</option>
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
                        <select class="form-control form-control-sm" wire:model="clip_type" id="clip_type">
                            <option selected value="">Selecciona un tipo</option>
                            <option value="Clip">Clip</option>
                            <option value="Precinto">Precinto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="long">Largo</label>
                        <input type="text" class="form-control" id="long" wire:model="long"
                            placeholder="Largo en mm">
                    </div>
                    <div class="form-group">
                        <label for="width">Ancho</label>
                        <input type="text" class="form-control" id="width" wire:model="width"
                            placeholder="Ancho en mm">
                    </div>
                    <div class="form-group">
                        <label for="hole_diameter">Diámetro del Orificio</label>
                        <input type="text" class="form-control" id="hole_diameter" wire:model="hole_diameter"
                            placeholder="Diámetro del Orificio">
                    </div>
                @break
                
            @endswitch
            @if ($materialFamily)
                <div class="form-group">
                    <label for="replace">Reemplazo</label>
                    <select class="form-control form-control-sm" wire:model="replace" id="replace">
                        @if ($rplce != null)
                            <option value="{{ $rplce->id }}" selected>{{ $rplce->name }}</option>
                        @else
                            <option selected>Seleccione un reemplazo</option>
                        @endif
                        @foreach ($materialFamily as $rep)
                            @if ($rplce != null)
                                @if ($rplce->id === $rep->id)
                                    @php continue;  @endphp
                                @endif
                            @endif
                            <option value="{{ $rep->id }}"> {{ $rep->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
