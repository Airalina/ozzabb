<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registro de Domicilio</h3>
              </div>
              
              <form>
                    <div class="card-body">                        
                        <h5>Datos del domicilio de entrega</h5>
                        <br>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Calle</label>
                            <input class="form-control form-control-sm" type="text" wire:model="street" placeholder="Ingrese calle">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Numero</label>
                            <input class="form-control form-control-sm" type="text" wire:model="number" placeholder="Ingrese numero">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Localidad</label>
                            <input class="form-control form-control-sm" type="text" wire:model="location" placeholder="Ingrese localidad">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Provincia</label>
                            <input class="form-control form-control-sm" type="text" wire:model="province" placeholder="Ingrese provincia">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pais</label>
                            <input class="form-control form-control-sm" type="text" wire:model="country" placeholder="Ingrese pais">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Codigo Postal</label>
                            <input class="form-control form-control-sm" type="text" wire:model="postcode" placeholder="Ingrese codigo postal">
                        </div>
                    </div>
                    <div class="card-footer">
                        <td><button wire:click="storedir( {{ $cliente }})" type="button" class="btn btn-primary">Guardar Cambios</button></td>
                    </div>
              </form>
</div>