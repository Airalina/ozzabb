
<div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                @if($funcion=="crear")<h3 class="card-title">Agregar Proveedor</h3>@else<h3 class="card-title">Informacion sobre el Proveedor: {{$name}}</h3>@endif
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
						<label for="name">Nombre de la empresa</label>
						<input type="text" class="form-control" id="name" wire:model="name" placeholder="Nombre de la empresa" required>
					</div>
					<div class="form-group">
						<label for="address">Domicilio</label>
						<input type="text" class="form-control" id="address" wire:model="address" placeholder="Domicilio" required>
					</div>
                    <div class="form-group">
						<label for="phone">Teléfono</label>
						<input type="text" class="form-control" id="phone" wire:model="phone" placeholder="Teléfono">
					</div>
					<div class="form-group">
						<label for="email">Correo electrónico para ventas</label>
						<input type="email" class="form-control" id="email" wire:model="email" placeholder="Correo electrónico para ventas" required>
					</div>
					<div class="form-group">
						<label for="contact_name">Nombre de contacto</label>
						<input type="text" class="form-control" id="contact_name" pattern="[A-Za-z]" wire:model="contact_name" placeholder="Nombre de contacto">
					</div>
					<div class="form-group">
						<label for="point_contact">Puesto de contacto</label>
						<input type="text" class="form-control" id="point_contact" wire:model="point_contact" placeholder="Puesto de contaco">
					</div>
                    <div class="form-group">
						<label for="site_url">Página web</label>
						<input type="text" class="form-control" id="site_url" wire:model="site_url" placeholder="Página web">
					</div>
					<div class="form-group">
                        <input type="checkbox" wire:model="status" class="form-check-input" id="exampleCheck1"  checked="">
						<label for="exampleCheck1">Activo</label>
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