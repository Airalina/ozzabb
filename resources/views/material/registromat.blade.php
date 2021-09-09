<div class="card card-primary">
              <div class="card-header">
              @if($funcion=="crearmat")<h3 class="card-title">Agregar Precio</h3>@else<h3 class="card-title">Informacion sobre el precio: </h3>@endif
          
              </div>
              
              <form>
                    <div class="card-body">                        
                        <h5>Datos del material</h5>
                        <br>    
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        
                        @endif

                        @if($addProvider)
    
                        <div class="form-group">
                            <label for="name_provider">Nombre de la empresa</label>
                            <input type="text" class="form-control" id="name_provider" wire:model="name_provider" placeholder="Nombre de la empresa" required>
                        </div>
                        <div class="form-group">
                                <label for="addres_provider">Domicilio</label>
                                <input type="text" class="form-control" id="addres_provider" wire:model="addres_provider" placeholder="Domicilio" required>
                        </div>
                        <div class="form-group">
                                <label for="email_provider">Correo electrónico para ventas</label>
                                <input type="email" class="form-control" id="email_provider" wire:model="email_provider" placeholder="Correo electrónico para ventas" required>
                        </div>
                        
                        @else
                        <div class="form-group">
                            <button wire:click="addProvider()" type="button" class="btn btn-info">Añadir proveedor</button>
                        </div>
                        <div class="form-group">
                        
                            <select wire:model="provider"  id="provider" class="form-control form-control-sm">
                            @if($mat_n !=null)
                            <option value="{{ $mat_n->id }}" selected> {{ $mat_n->name }}</option>
                            @else
                            <option selected>Seleccione un proveedor</option>
                            @endif
                            @foreach($info_pro as $pro)
                                @if($mat_n !=null)
                                    @if($mat_n->id === $pro->id)
                                        @php continue;  @endphp
                                    @endif
                                @endif
                            <option value="{{ $pro->id }}">{{ $pro->name }}</option> 
                             @endforeach
                            </select>
                        </div>   
                        @endif
                        <div class="form-group">
                            <label for="unit">Unidad de presentación</label>
                            <div class="d-flex">
                            <input class="form-control form-control-sm" type="string"  id="unit" wire:model="unit" placeholder="Ingrese las unidades">
                            <select class="form-control form-control-sm" wire:model="presentation"  id="presentation">
                                <option selected value="">Selecciona una medida</option>
                                <option value="mm">Milímetros</option>
                                <option value="und">Unidades</option>
                                <option value="cajas">Cajas</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="usd_price">Precio U$D</label>
                            <input class="form-control form-control-sm" type="text"  id="usd_price" wire:model="usd_price" placeholder="Ingrese el precio U$D">
                        </div>
                        <div class="form-group">
                            <label for="ars_price">Precio AR$</label>
                            <input class="form-control form-control-sm" type="text"  id="ars_price" wire:model="ars_price" placeholder="Ingrese el precio AR$">
                        </div>
                    </div>
                    <div class="card-footer">
                    @if($funcion=="crearmat")
                    <td><button wire:click="storemat({{ $material->id }})"  type="button" class="btn btn-primary">Guardar</button></td>
                        
				@else
						<td><button wire:click="editarmat()" type="button" class="btn btn-primary">Guardar Cambios</button></td>
				@endif
                        
                        <td><button wire:click="backmat()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
              </form>
    

</div>
