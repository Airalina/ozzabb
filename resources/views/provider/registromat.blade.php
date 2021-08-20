<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registro de Material</h3>
              </div>
              
              <form>
                    <div class="card-body">                        
                        <h5>Datos del material</h5>
                        <br>
                        <div class="form-group">
                            <label for="code">Código de material</label>
                            <input class="form-control form-control-sm" type="text" wire:model="code" placeholder="Ingrese el código" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input class="form-control form-control-sm" type="text" wire:model="name_material" placeholder="Ingrese el nombre">
                        </div>
                        <div class="form-group">
                            <label for="stock">Cantidad</label>
                            <input class="form-control form-control-sm" type="string" wire:model="stock" placeholder="Ingrese la cantidad">
                        </div>
                        <div class="form-group">
                            <label for="unit">Unidad de presentación</label>
                            <div class="d-flex">
                            <input class="form-control form-control-sm" type="string" wire:model="unit" placeholder="Ingrese las unidades">
                            <select class="form-control form-control-sm" wire:model="presentation">
                                <option value="0" disabled selected>Selecciona una medida</option>
                                <option value="mm">Milímetros</option>
                                <option value="und">Unidades</option>
                                <option value="cajas">Cajas</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="usd_price">Precio U$D</label>
                            <input class="form-control form-control-sm" type="text" wire:model="usd_price" placeholder="Ingrese el precio U$D">
                        </div>
                        <div class="form-group">
                            <label for="ars_price">Precio AR$</label>
                            <input class="form-control form-control-sm" type="text" wire:model="ars_price" placeholder="Ingrese el precio AR$">
                        </div>
                    </div>
                    <div class="card-footer">
                         
                        <td><button wire:click="storemat({{ $provider }})"  type="button" class="btn btn-primary">Guardar</button></td>
                        
                        <td><button wire:click="cancelarup()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
              </form>
</div>