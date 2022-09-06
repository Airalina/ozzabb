<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
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
                            <label>Seleccione Cliente:</label>
                            <br>
                            <div class="input-group input-group-sm" style="width: 150px;">
                              <input wire:model="searchcustomer" type="text" class="form-control form-control-xs float-right" placeholder="Buscar cliente...">
                            </div>
                            @if($searchcustomer!="")
                              @if(!empty($clientes))
                                <div class="card-body table-responsive p-0">
                                  <table class="table table-hover table-sm">
                                    <thead>
                                      <tr>
                                        <th style="text-align: center">Nombre</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @forelse($clientes as $customer)
                                        <tr>
                                          <td style="text-align: center">{{ $customer->name }}</td>
                                          <td><button type="button"  wire:click.prevent="selectcustomer({{ $customer->id }})" class="btn btn-success btn-sm">Seleccionar</button></td>
                                        </tr>
                                        @empty
                                          <tr class="text-center">
                                            <td colspan="4" class="py-3 italic">No hay información</td>
                                          </tr>
                                      @endforelse
                                    </tbody>
                                  </table>
                                </div>
                              @endif
                            @endif
                            @if(!empty($cliente_name))
                              <br>
                              <label>Cliente seleccionado:</label>
                              <p>{{$cliente_name}}</p>
                            @endif
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
                            <label>Horas/hombre requeridas</label>
                            <input class="form-control form-control-sm" type="text" wire:model="hours_man" placeholder="Ingrese horas/hombre de instalación">
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