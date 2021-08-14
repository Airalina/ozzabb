<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Actualizar informacion de cliente con codigo:  {{ $cliente->id }}</h3>
              </div>
        <div class="card-body">
                        <h5>Datos de contacto</h5> 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input class="form-control form-control-sm" type="text" wire:model="name" placeholder="Ingrese nombre del cliente">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input class="form-control form-control-sm" type="email" wire:model="email" placeholder="Ingrese email del cliente">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Teléfono</label>
                            <input class="form-control form-control-sm" type="text" wire:model="phone" placeholder="Ingrese domicilio administrativo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Domicilio de administración</label>
                            <input class="form-control form-control-sm" type="text" wire:model="domicile_admin" placeholder="Ingrese domicilio administrativo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Contacto</label>
                            <input class="form-control form-control-sm" type="text" wire:model="contact" placeholder="Ingrese nombre del contacto">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Cargo de contacto</label>
                            <input class="form-control form-control-sm" type="text" wire:model="post_contact" placeholder="Ingrese cargo del contacto">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" wire:model="estado" class="form-check-input" id="exampleCheck1"  checked="">
                            <label for="exampleInputEmail1">Estado</label>
                        </div>
                        <div>
                            <h6>Los cambios realizados en el siguiente formulario, se verán reflejados en proximo ingreso a este cliente</h6>
                        </div>
                        <div class="card-footer">
                            <td><button wire:click="editar({{ $cliente->id }})" type="button" class="btn btn-primary">Guardar Cambios</button></td>
                        
                            <td><button wire:click="cancelarup()" type="button" class="btn btn-primary">Cancelar</button></td>
                        </div>
</div>