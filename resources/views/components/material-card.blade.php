            @switch($div)
                @case("Conectores")
                    <div class="form-group">
                        <label for="terminal">Terminales Asociado</label>
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="search" type="text" class="form-control float-right"
                                placeholder="Buscar Material...">
                        </div>
                        @if($search!=null)
                        <table>
                            <thead>
                                <tr>
                                    <th style="text-align: center">Codigo</th>
                                    <th style="text-align: center">Nombre</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach($infoTerm as $terminal)
                                <tbody>
                                    <td>{{$terminal->code}}</td>
                                    <td>{{$terminal->name}}</td>
                                    <td><button wire:click="addterminal({{ $terminal->id }})" type="button"  class="btn btn-primary btn-sm">+</button></td>
                                </tbody>
                            @endforeach
                        </table>
                        @endif
                        <label for="terminal">Terminales Asociados Seleccionados:</label>
                        <table>
                            <thead>
                                <tr>
                                    <th style="text-align: center">Codigo</th>
                                    <th style="text-align: center">Nombre</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach($terminales as $terminal)
                                <tbody>
                                    <td>{{$terminal[2]}}</td>
                                    <td>{{$terminal[1]}}</td>
                                    <td><button wire:click="dropterminal({{ $terminal[3] }})" type="button"  class="btn btn-danger btn-sm">-</td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                
                    <div class="form-group">
                        <label for="sello">Sellos Asociados</label>
                            <div class="input-group input-group-sm mb-4" style="width: 150px;">
                                <input wire:model="searchs" type="text" class="form-control float-right"
                                    placeholder="Buscar Material...">
                            </div>
                            @if($searchs!=null)
                            <table class="table table-head table-sm">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">Código</th>
                                        <th style="text-align: center">Tipo</th>
                                        <th style="text-align: center">Diámetro mínimo de cable</th>
                                        <th style="text-align: center">Diámetro máximo de cable</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @foreach($infoSell as $material)
                                    <tbody>
                                        <td style="text-align: center">{{ $material->code }}</td>
                                        <td style="text-align: center">{{ $material->seal->type }}</td>
                                        <td style="text-align: center">{{ $material->seal->minimum_diameter }}</td>
                                        <td style="text-align: center">{{ $material->seal->maximum_diameter }}</td>
                                        <td style="text-align: center"><button wire:click="addsello({{ $material->id }})" type="button"  class="btn btn-primary btn-sm">+</button></td>
                                    </tbody>
                                @endforeach
                            </table>
                            @endif
                            @if (count($sellos) > 0)
                            <label for="sello">Sellos Asociados Seleccionados:</label>
                            <table class="table table-head table-sm">
                                <thead>
                                    <tr> 
                                        <th style="text-align: center">Código</th>
                                        <th style="text-align: center">Tipo</th>
                                        <th style="text-align: center">Diámetro mínimo de cable</th>
                                        <th style="text-align: center">Diámetro máximo de cable</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @foreach($sellos as $sello)
                                    <tbody>
                                        <td style="text-align: center">{{ $sello[2] }}</td>
                                        <td style="text-align: center">{{ $sello[3] }}</td>
                                        <td style="text-align: center">{{ $sello[4] }}</td>
                                        <td style="text-align: center">{{ $sello[5] }}</td>
                                        <td style="text-align: center"><button wire:click="dropsello({{ $sello[0] }})" type="button"  class="btn btn-danger btn-sm">-</td>
                                    </tbody>
                                @endforeach
                            </table>
                            @endif
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
                            @if ($connectorId != null)
                                <option>Seleccione una contraparte</option>
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
                            placeholder="Grosor del cable en mm (para decimales usar 'punto(.)')">
                    </div>
                    <div class="form-group">
                        <label for="base_color">Color base</label>
                        <select class="form-control form-control-sm" wire:model="base_color" id="base_color">
                            <option selected value="">Selecciona un color</option>
                            <option value="Negro" class="text-dark">Negro</option>
                            <option value="Marrón" style="color:saddlebrown">Marrón</option>
                            <option value="Rojo" class="text-danger">Rojo</option>
                            <option value="Naranja" style="color:orange">Naranja</option>
                            <option value="Amarillo" class="text-warning">Amarillo</option>
                            <option value="Verde" class="text-success">Verde</option>
                            <option value="Azul" class="text-primary">Azul</option>
                            <option value="Violeta" style="color:violet">Violeta</option>
                            <option value="Gris" style="color:grey">Gris</option>
                            <option value="Blanco">Blanco</option>
                            <option value="Rosado" style="color:palevioletred">Rosado</option>
                            <option value="Verde claro" style="color:lightgreen">Verde claro</option>
                            <option value="Celeste" style="color:cadetblue">Celeste</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="line_color">Color Línea</label>
                        <select class="form-control form-control-sm" wire:model="line_color" id="line_color">
                            <option selected value="">Selecciona un color</option>
                            <option value="Negro" class="text-dark">Negro</option>
                            <option value="Marrón" style="color:saddlebrown">Marrón</option>
                            <option value="Rojo" class="text-danger">Rojo</option>
                            <option value="Naranja" style="color:orange">Naranja</option>
                            <option value="Amarillo" class="text-warning">Amarillo</option>
                            <option value="Verde" class="text-success">Verde</option>
                            <option value="Azul" class="text-primary">Azul</option>
                            <option value="Violeta" style="color:violet">Violeta</option>
                            <option value="Gris" style="color:grey">Gris</option>
                            <option value="Blanco">Blanco</option>
                            <option value="Rosado" style="color:palevioletred">Rosado</option>
                            <option value="Verde claro" style="color:lightgreen">Verde claro</option>
                            <option value="Celeste" style="color:cadetblue">Celeste</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="braid_configuration">Configuración de Trenza</label>
                        <select class="form-control form-control-sm" wire:model="braid_configuration"
                            id="braid_configuration">
                            <option selected value="">Selecciona una configuración</option>
                            <option value="16 x 30 mm">16 x 30 mm</option>
                            <option value="34 x 20 mm">34 x 20 mm</option>
                            <option value="7 x 0.25 mm">7 x 0.25 mm</option>
                            <option value="16 x 0.20 mm">16 x 0.20 mm</option>
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
                            placeholder="Temperatura en grados Celsius (para decimales usar 'punto(.)')">
                    </div>
                @break
                @case("Terminales")
                    <div class="form-group">
                        <label for="size">Tamaño</label>
                        <input type="text" class="form-control" id="size" wire:model="size" placeholder="Tamaño en mm (para decimales usar 'punto(.)')">
                    </div>
                    <div class="form-group">
                        <label for="minimum_section">Sección mínima agrafado</label>
                        <input type="text" class="form-control" id="minimum_section" wire:model="minimum_section"
                            placeholder="Sección mínima (para decimales usar 'punto(.)')">
                    </div>
                    <div class="form-group">
                        <label for="maximum_section">Sección máxima agrafado</label>
                        <input type="text" class="form-control" id="maximum_section" wire:model="maximum_section"
                            placeholder="Sección máxima (para decimales usar 'punto(.)')">
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
                            <option value="Ojal">Ojal</option>
                        </select>
                    </div>
                @break
                @case("Sellos")
                    <div class="form-group">
                        <label for="minimum_diameter">Diámetro mínimo de Cable</label>
                        <input type="text" class="form-control" id="minimum_diameter" wire:model="minimum_diameter"
                            placeholder="Diámetro mínimo de Sello (para decimales usar 'punto(.)')">
                    </div>
                    <div class="form-group">
                        <label for="maximum_diameter">Diámetro máximo de Cable</label>
                        <input type="text" class="form-control" id="maximum_diameter" wire:model="maximum_diameter"
                            placeholder="Diámetro máximo de Cable (para decimales usar 'punto(.)')">
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
                            <option value="Barnizado">Barnizado</option>
                            <option value="Corrugado">Corrugado</option>
                            <option value="Termocontraible">Termocontraible</option>
                            <option value="PVC">PVC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tube_diameter">Diámetro</label>
                        <input type="text" class="form-control" id="tube_diameter" wire:model="tube_diameter"
                            placeholder="Diámetro del tubo en milímetros (para decimales usar 'punto(.)')">
                    </div>
                    <div class="form-group">
                        <label for="wall_thickness">Espesor de pared</label>
                        <input type="text" class="form-control" id="wall_thickness" wire:model="wall_thickness"
                            placeholder="Grosor de la pared del tubo en mm (para decimales usar 'punto(.)')">
                    </div>
                     @if ($divTube)
                        <div class="form-group">
                            <label for="contracted_diameter">Diámetro Contraído</label>
                            <input type="text" class="form-control" id="contracted_diameter" wire:model="contracted_diameter"
                                placeholder="Diámetro del tubo una vez contraído (para decimales usar 'punto(.)')">
                        </div>
                        <div class="form-group">
                            <label for="minimum_temperature">Temperatura mínima de Servicio</label>
                            <input type="text" class="form-control" id="minimum_temperature" wire:model="minimum_temperature"
                                placeholder="Temperatura mínima de Servicio (para decimales usar 'punto(.)')">
                        </div>
                        <div class="form-group">
                            <label for="maximum_temperature">Temperatura máxima de Servicio</label>
                            <input type="text" class="form-control" id="maximum_temperature" wire:model="maximum_temperature"
                                placeholder="Temperatura máxima de Servicio (para decimales usar 'punto(.)')">
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
                            <option value="Tapón ciego">Tapón ciego</option>
                            <option value="Pasante de goma">Pasante de Goma</option>
                            <option value="Portafusible">Portafusible</option>
                            <option value="Moldeado">Moldeado</option>
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
                            placeholder="Largo en mm (para decimales usar 'punto(.)')">
                    </div>
                    <div class="form-group">
                        <label for="width">Ancho</label>
                        <input type="text" class="form-control" id="width" wire:model="width"
                            placeholder="Ancho en mm (para decimales usar 'punto(.)')">
                    </div>
                    <div class="form-group">
                        <label for="hole_diameter">Diámetro del Orificio</label>
                        <input type="text" class="form-control" id="hole_diameter" wire:model="hole_diameter"
                            placeholder="Diámetro del Orificio (para decimales usar 'punto(.)')">
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
