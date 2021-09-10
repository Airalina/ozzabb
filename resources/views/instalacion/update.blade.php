<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registro de Instalación</h3>
              </div>
              
              <form>
                @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                @endif
                    <div class="card-body">
                        <h5>Datos de Instalación</h5>
                        <br>    
                        <div class="form-group">
                            <label>Código</label>
                            <input class="form-control form-control-sm" type="text" wire:model="code" placeholder="Ingrese código de instalación">
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea class="form-control form-control-sm" rows="3" wire:model="description" placeholder="Descripción ..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Precio U$D</label>
                            <input class="form-control form-control-sm" type="text" wire:model="usd_price" placeholder="Ingrese precio en dolares (para decimales usar 'punto(.)')">
                        </div>
                        <div class="form-group">
                            <label>Fecha de Ingreso</label>
                            <label>{{ date('d-m-Y', strtotime($date_admission)) }}</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <td><button wire:click="edit()" type="button" class="btn btn-primary">Guardar </button></td>
                        <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
                 </form>
</div>