
<div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                @if($funcion=="crear")<h3 class="card-title">Agregar Material</h3>@else<h3 class="card-title">Informacion sobre el Material: {{$name}}</h3>@endif
              </div>
			  
              <form>
				  
				<div class="card-body">
				@if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        
                        @endif
                    <div class="form-group">
						<label for="code">Código del material</label>
						<input type="text" class="form-control" id="code" wire:model="code" placeholder="Código del material" required>
					</div>
                    <div class="form-group">
						<label for="name">Nombre del material</label>
						<input type="text" class="form-control" id="name" wire:model="name" placeholder="Nombre del material" required>
					</div>
					<div class="form-group">
						<label for="family">Familia</label>
                        <select class="form-control form-control-sm" wire:model="family"  id="family">
                                <option selected value="">Selecciona una familia</option>
                                <option value="Conectores">conectores</option>
                                <option value="Cables">cables</option>
                                <option value="Terminales">terminales</option>
                                <option value="Sellos">sellos</option>
                        </select>
                    </div>
                    <div class="form-group" id="div">
                    <td><button wire:click="con()" type="button" class="btn btn-light">Agregar</button></td>
                    </div>
                    @switch($div)
                        @case("Conectores")
                            <div class="form-group">
                                <label for="terminal">Terminal Asociado</label>
                             
                                <select wire:model="terminal"  id="terminal" class="form-control form-control-sm">
                               
                                @if($terminal_id !=null)
                                <option value="{{ $termi->id  }}" selected>{{  $termi->material->name }}</option>
                                @else
                                <option selected>Seleccione un terminal</option>
                                @endif
                                @foreach($info_term as $term)
                                    @if($terminal_id !=null)
                                        @if($terminal_id === $term->id)
                                            @php continue;  @endphp
                                        @endif
                                    @endif
                                <option value="{{ $term->id }}"> {{ $term->material->name }}</option> 
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="seal">Sello Asociado</label>
                            
                                <select wire:model="seal"  id="seal" class="form-control form-control-sm">
                                    @if($seal_id !=null)
                                    <option value="{{ $seli->id }}" selected>{{  $seli->material->name }}</option>
                                    @else
                                    <option selected>Seleccione un sello</option>
                                    @endif
                                    @foreach($info_sell as $sell)
                                        @if($seal_id !=null)
                                            @if($seal_id === $sell->id)
                                                @php continue;  @endphp
                                            @endif
                                        @endif
                                        <option value="{{ $sell->id }}"> {{ $sell->material->name }}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="number_of_ways">Cantidad de vías</label>
                                <input type="text" class="form-control" id="number_of_ways" wire:model="number_of_ways" placeholder="Cantidad de vías">
                            </div>
                            <div class="form-group">
                                <label for="type">Tipo</label>
                                <select class="form-control form-control-sm" wire:model="type"  id="type">
                                        <option selected value="">Selecciona un tipo</option>
                                        <option value="Porta macho">Porta macho</option>
                                        <option value="Porta hembra">Porta hembra</option>
                                </select>
                            </div>
                            <div class="form-group">
                           
                                <label for="connector">Contraparte</label>
                                <select wire:model="connector"  id="connector" class="form-control form-control-sm">
                             
                                @if($connector_id !=null)
                                    <option value="{{ $connect->id }}" selected>{{  $connect->material->name }}</option>
                                    @else
                                    <option selected>Seleccione una contraparte</option>
                                    @endif
                                    @foreach($info_con as $con)
                                        @if($connector_id !=null)
                                            @if($connector_id === $con->id)
                                                @php continue;  @endphp
                                            @endif
                                        @endif
                                        <option value="{{ $con->id }}"> {{ $con->material->name }}</option> 
                                    @endforeach
                                </select>
                            </div>
                            @if($material_family)
                            <div class="form-group">
                                <label for="replace">Reemplazo</label>
                                <select class="form-control form-control-sm" wire:model="replace"  id="replace">
                                @if($rplce !=null)
                                    <option value="{{ $rplce->id }}" selected>{{  $rplce->name }}</option>
                                    @else
                                    <option selected>Seleccione un reemplazo</option>
                                    @endif
                                    @foreach($material_family as $rep)    
                                        @if($rplce !=null)
                                            @if($rplce->id === $rep->id)
                                                @php continue;  @endphp
                                            @endif
                                        @endif
                                        <option value="{{ $rep->id }}"> {{ $rep->name }}</option> 
                                    @endforeach
                                </select>	
                            </div>
                            @endif
                            @break
                            @case("Cables")
                            <div class="form-group">
                                <label for="size">Tamaño</label>
                                <input type="text" class="form-control" id="size" wire:model="size" placeholder="Tamaño en mm">
                            </div>
                            <div class="form-group">
                                <label for="minimum_section">Sección mínima</label>
                                <input type="text" class="form-control" id="minimum_section" wire:model="minimum_section" placeholder="Sección mínima">
                            </div>
                            <div class="form-group">
                                <label for="maximum_section">Sección máxima</label>
                                <input type="text" class="form-control" id="maximum_section" wire:model="maximum_section" placeholder="Sección máxima">
                            </div>
                            @if($material_family)
                            <div class="form-group">
                                <label for="replace">Reemplazo</label>
                                <select class="form-control form-control-sm" wire:model="replace"  id="replace">
                                @if($rplce !=null)
                                    <option value="{{ $rplce->id }}" selected>{{  $rplce->name }}</option>
                                    @else
                                    <option selected>Seleccione un reemplazo</option>
                                    @endif
                                    @foreach($material_family as $rep)    
                                        @if($rplce !=null)
                                            @if($rplce->id === $rep->id)
                                                @php continue;  @endphp
                                            @endif
                                        @endif
                                        <option value="{{ $rep->id }}"> {{ $rep->name }}</option> 
                                    @endforeach
                                </select>	
                            </div>
                            @endif
                            @break
                            @case("Terminales")
                            <div class="form-group">
                                <label for="size">Tamaño</label>
                                <input type="text" class="form-control" id="size" wire:model="size" placeholder="Tamaño en mm">
                            </div>
                            <div class="form-group">
                                <label for="minimum_section">Sección mínima</label>
                                <input type="text" class="form-control" id="minimum_section" wire:model="minimum_section" placeholder="Sección mínima">
                            </div>
                            <div class="form-group">
                                <label for="maximum_section">Sección máxima</label>
                                <input type="text" class="form-control" id="maximum_section" wire:model="maximum_section" placeholder="Sección máxima">
                            </div>
                            @if($material_family)
                            <div class="form-group">
                                <label for="replace">Reemplazo</label>
                                <select class="form-control form-control-sm" wire:model="replace"  id="replace">
                                @if($rplce !=null)
                                    <option value="{{ $rplce->id }}" selected>{{  $rplce->name }}</option>
                                    @else
                                    <option selected>Seleccione un reemplazo</option>
                                    @endif
                                    @foreach($material_family as $rep)    
                                        @if($rplce !=null)
                                            @if($rplce->id === $rep->id)
                                                @php continue;  @endphp
                                            @endif
                                        @endif
                                        <option value="{{ $rep->id }}"> {{ $rep->name }}</option> 
                                    @endforeach
                                </select>	
                            </div>
                            @endif
                            @break
                            @default
                            @if($material_family)
                            <div class="form-group">
                                <label for="replace">Reemplazo</label>
                                <select class="form-control form-control-sm" wire:model="replace"  id="replace">
                                @if($rplce !=null)
                                    <option value="{{ $rplce->id }}" selected>{{  $rplce->name }}</option>
                                    @else
                                    <option selected>Seleccione un reemplazo</option>
                                    @endif
                                    @foreach($material_family as $rep)    
                                        @if($rplce !=null)
                                            @if($rplce->id === $rep->id)
                                                @php continue;  @endphp
                                            @endif
                                        @endif
                                        <option value="{{ $rep->id }}"> {{ $rep->name }}</option> 
                                    @endforeach
                                </select>	
                            </div>
                            @endif
                    @endswitch


                    <div class="form-group">
						<label for="color">Color</label>
                        <select class="form-control form-control-sm" wire:model="color"  id="color">
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
                        <textarea name="description" class="form-control"  wire:model="description" id="description" cols="30" rows="3"></textarea>
					</div>
					<div class="form-group">
                    <label for="line">Línea</label>
                    <select wire:model="line"  id="line" class="form-control form-control-sm">
                            @if($line_id !=null)
                            <option value="{{ $line_id->id }}" selected>{{  $line_id->name }}</option>
                            @else
                            <option selected>Seleccione una línea</option>
                            @endif
                            @foreach($info_line as $ln)
                                @if($line_id !=null)
                                    @if($line_id->id === $ln->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                            <option value="{{ $ln->id }}">{{ $ln->name }}</option> 
                             @endforeach
                    </select>
                    </div>
					<div class="form-group">
						<label for="usage">Uso</label>
						<select wire:model="usage"  id="usage" class="form-control form-control-sm">
                            @if($usage_id !=null)
                            <option value="{{ $usage_id->id }}" selected>{{  $usage_id->name }}</option>
                            @else
                            <option selected>Seleccione un uso</option>
                            @endif
                            @foreach($info_usage as $usg)
                                @if($usage_id !=null)
                                    @if($usage_id->id === $usg->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                            <option value="{{ $usg->id }}">{{ $usg->name }}</option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
						<label for="stock_min">Stock mínimo</label>
						<input type="text" class="form-control" id="stock_min" wire:model="stock_min" placeholder="Stock mínimo del material">
					</div>
                    <div class="form-group">
						<label for="stock_max">Stock máximo</label>
						<input type="text" class="form-control" id="stock_max" wire:model="stock_max" placeholder="Stock máximo del material">
					</div>
                    <div class="form-group">
						<label for="stock">Stock en planta</label>
						<input type="text" class="form-control" id="stock" wire:model="stock" placeholder="Stock en planta">
					</div>
				</div>
                <div class="card-footer">
				@if($funcion=="crear")
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar</button></td>
				@else
						<td><button wire:click="editar()" type="button" class="btn btn-primary">Guardar Cambios</button></td>
				@endif
                        <td><button wire:click="back()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
             </form>
            </div>
