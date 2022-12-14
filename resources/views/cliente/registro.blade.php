<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="col-md-6">
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registro de cliente</h3>
              </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
              <form>
                    <div class="card-body">
                        <h5>Datos de contacto</h5>
                        <br>    
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input class="form-control form-control-sm" type="text" wire:model="name"  placeholder="Ingrese nombre del cliente">
                        </div>
                        <div class="form-group">
                            <label for="cuit">CUIT</label>
                            <input type="text" class="form-control form-control-sm" id="cuit" wire:model="cuit" placeholder="CUIT">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input class="form-control form-control-sm" type="email" wire:model="email"  placeholder="Ingrese email del cliente">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Teléfono</label>
                            <input class="form-control form-control-sm" type="text" wire:model="phone"  placeholder="Ingrese domicilio administrativo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Domicilio de administración</label>
                            <input class="form-control form-control-sm" type="text" wire:model="domicile_admin"  placeholder="Ingrese domicilio administrativo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Contacto</label>
                            <input class="form-control form-control-sm" type="text" wire:model="contact"  placeholder="Ingrese nombre del contacto">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Cargo de contacto</label>
                            <input class="form-control form-control-sm" type="text" wire:model="post_contact"  placeholder="Ingrese cargo del contacto">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" wire:model="estado" class="form-check-input" id="exampleCheck1" value="true"   checked="">
                            <label for="exampleInputEmail1">Estado (indica si el cliente esta activo o no)</label>
                        </div>
                        <br>
                        <h5>Datos del domicilio de entrega</h5>
                        <br>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Calle</label>
                            <input class="form-control form-control-sm" type="text" wire:model="street"  placeholder="Ingrese calle">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Numero</label>
                            <input class="form-control form-control-sm" type="text" wire:model="number"  placeholder="Ingrese numero">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Localidad</label>
                            <input class="form-control form-control-sm" type="text" wire:model="location"  placeholder="Ingrese localidad">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Provincia</label>
                            <input class="form-control form-control-sm" type="text" wire:model="province"  placeholder="Ingrese provincia">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">País</label>
                            <input class="form-control form-control-sm" type="text" wire:model="country" placeholder="Ingrese pais">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Codigo Postal</label>
                            <input class="form-control form-control-sm" type="text" wire:model="postcode"  placeholder="Ingrese codigo postal">
                        </div>
                    </div>
                    <div class="card-footer">
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                        <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
              </form>
</div>
</div>