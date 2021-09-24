
<div class="col-md-6">
            <!-- general form elements -->
			@if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
            <div class="card card-primary">
              <div class="card-header">
                @if($funcion=="crear")<h3 class="card-title">Agregar Usuario</h3>@else<h3 class="card-title">Informacion sobre el usuario: {{$name}}</h3>@endif
              </div>
              <form>
				<div class="card-body">
					@if($funcion=="crear")
					<div class="form-group">
						<label for="exampleInputEmail1">Nombre Usuario</label>
						<input type="text" class="form-control" id="name" wire:model="name" placeholder="Nombre de Usuario">
					</div>
					@endif
					<div class="form-group">
						<label for="exampleInputEmail1">Nombre y Apellido</label>
						<input type="text" class="form-control" id="nombre_y_apellido" wire:model="nombre_y_apellido" placeholder="Nombre y Apellido">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Email</label>
						<input type="email" class="form-control" id="email" wire:model="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Telefono</label>
						<input type="text" class="form-control" id="telefono" wire:model="telefono" placeholder="Telefono">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Domicilio</label>
						<input type="text" class="form-control" id="domicilio" wire:model="domicilio" placeholder="Domicilio">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">D.N.I.</label>
						<input type="text" class="form-control" id="dni" wire:model="dni" placeholder="D.N.I.">
					</div>
					@if($funcion=="crear")
					<div class="form-group">
						<label for="exampleInputEmail1">Contraseña</label>
						<input id="password" class="form-control" wire:model="password" type="password" name="password" required autocomplete="new-password" placeholder="Contraseña" />
					</div>	
					<div class="mt-4">
						<label for="exampleInputEmail1">Repetir contraseña</label>
						<input id="password_confirmation" class="form-control" wire:model="password1" type="password" name="password_confirmation" required placeholder="Contraseña"/>
            		</div>
					@endif
				</div>
             </form>
            </div>