<div>
      <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
    <br>
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
							<label for="exampleInputEmail1">Nombre Rol</label>
							<input type="text" class="form-control form-control-sm" id="name" wire:model="nombre" placeholder="Nombre de Rol">
					</div>
				</div>
			  </form>
			</div>  	  	  
</div>
    