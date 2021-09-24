<div class="col-md-6">
@if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                @if($funcion=="crear")
					<h3 class="card-title">Agregar Rol</h3>@else<h3 class="card-title">Cambiar Nombre del Rol</h3>
				@endif
              </div>
              <form>
				<div class="card-body">
					<div class="form-group">
							<label for="exampleInputEmail1">Nombre Usuario</label>
							<input type="text" class="form-control" id="name" wire:model="nombre" placeholder="Nombre de Usuario">
					</div>
				</div>
			  </form>
			</div>  	  	  
</div>
    