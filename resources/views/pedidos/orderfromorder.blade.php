<div>
  <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Nuevo pedido</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
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
                  <div class="form-group">
                    <br>
                    <h4>Cliente</h4>
                    @if($selectcustomer==false)
                      <div class="input-group input-group-sm" style="width: 150px;">
                          <input wire:model="searchclient" type="text" class="form-control float-right" placeholder="Buscar Cliente...">
                      </div>
                    @if($searchclient!="")
                    <div class="card-body p-0">
                        <table class="table  table-hover table-sm">
                        <thead>
                            <tr>
                            <th style="text-align: center">Nombre</th>
                            <th style="text-align: center">Teléfono</th>
                            <th style="text-align: center">Email</th>
                            <th style="text-align: center">Domicilio Administración</th>
                            <th style="text-align: center">Estado</th>
                            </tr>
                        </thead>  
                    <tbody>
                    @forelse($customers as $cliente)
                        <tr class="registros">
                            <td style="text-align: center">{{ $cliente->name }}</td>
                            <td style="text-align: center">{{ $cliente->phone }}</td>
                            <td style="text-align: center">{{ $cliente->email}}</td>
                            <td style="text-align: center">{{ $cliente->domicile_admin}}</td>
                            @if($cliente->estado==true)
                                <td style="text-align: center">Activo</td>
                            @else
                                <td style="text-align: center">Inactivo</td>
                            @endif
                            <td style="text-align: center">
                                <button type="button" wire:click="selectcustomer({{ $cliente->id }})" class="btn btn-primary btn-sm"> Seleccionar</button>
                            </td>      
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
              @else
                <label>Useted ha seleccionado al cliente: {{ $customer->name }}</label>
                <br>
                <label>Domicilio administrativo del cliente: {{$customer->domicile_admin}}</label>
                <br>
                <label>Domicilio de entrega:</label>
                <br>
                <div class="card-body p-0">
                  <table class="table table-hover table-sm">
                    <thead>
                      <tr>
                        <th style="text-align: center">Calle</th>
                        <th style="text-align: center">Numero</th>
                        <th style="text-align: center">Localidad</th>
                        <th style="text-align: center">Provincia</th>
                        <th style="text-align: center">País</th>
                        <th style="text-align: center">Codigo Postal</th>
                        <th style="text-align: center"> @if($addaddress==false)<button type="button" wire:click="addaddress()" class="btn btn-primary btn-sm"> Otra Dirección</button>@endif</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($addaddress==false)
                      @if($selectaddress==false)
                      @foreach($address as $addres)
                      <tr>
                        <td style="text-align: center">{{ $addres->street }}</td>
                        <td style="text-align: center">{{ $addres->number }}</td>
                        <td style="text-align: center">{{ $addres->location }}</td>
                        <td style="text-align: center">{{ $addres->province }}</td>
                        <td style="text-align: center">{{ $addres->country }}</td>
                        <td style="text-align: center">{{ $addres->postcode }}</td>
                        <td style="text-align: center"><button type="button" wire:click="selectadd({{ $addres->id }})" class="btn btn-success btn-sm"> Seleccionar</button></td>
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td style="text-align: center">{{ $address->street }}</td>
                        <td style="text-align: center">{{ $address->number }}</td>
                        <td style="text-align: center">{{ $address->location }}</td>
                        <td style="text-align: center">{{ $address->province }}</td>
                        <td style="text-align: center">{{ $address->country }}</td>
                        <td style="text-align: center">{{ $address->postcode }}</td>
                        <td style="text-align: center"><button type="button" wire:click="cancelaradd({{ $customer->id }})" class="btn btn-danger btn-sm">Cancelar Selección</button></td>
                      </tr>
                      @endif

                      @else
                      <tr>
                        <td style="text-align: center"><input wire:model="street" type="text" class="form-control form-control-sm"></td>
                        <td style="text-align: center"><input wire:model="number" type="number" class="form-control form-control-sm"></td>
                        <td style="text-align: center"><input wire:model="location" type="text" class="form-control form-control-sm"></td>
                        <td style="text-align: center"><input wire:model="province" type="text" class="form-control form-control-sm"></td>
                        <td style="text-align: center"><input wire:model="country" type="text" class="form-control form-control-sm"></td>
                        <td style="text-align: center"><input wire:model="postcode" type="text" class="form-control form-control-sm"></td>
                        <td style="text-align: center"><button type="button" wire:click="cancelarnewadd()" class="btn btn-danger btn-sm">Cancelar</button></td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              @endif
              <br>
              <h4><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fecha de entrega estimada:</font></font></h4>
                    <input type="date" wire:model="deadline" class="form-control form-control-sm" style="width: auto" placeholder="dd/mm/AAAA" >
                    <br>
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Seleccione instalación a ser agregada</h3>
                          <br>
                          <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="searchinstallation" type="text" class="form-control float-right" placeholder="Buscar instalación...">
                          </div>
                        </div>
                        <!-- /.card-header -->
                        @if($searchinstallation!="")
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover table-sm">
                            <thead>
                              <tr>
                                <th style="text-align: center">Cod.</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">P/U U$D</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            @forelse($installations as $install)
                              <tr>
                                <td style="text-align: center">{{ $install->code }}</td>
                                <td style="text-align: center">{{ $install->description}}</td>
                                <td style="text-align: center">{{ $install->usd_price }}</td>                   
                                <td><button type="button"  wire:click="selectinstallation({{ $install->id }})" class="btn btn-success btn-sm">Agregar</button></td>
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
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Detalle</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover table-sm">
                            <thead>
                              <tr>
                                <th style="text-align: center">Codigo instalación</th>
                                <th style="text-align: center">Precio Unitario U$D</th>
                                <th style="text-align: center">Cantidad</th>
                                <th style="text-align: center">Subtotal</th>
                                <th style="text-align: center">Accion</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($details as $algo)  
                              <tr>
                                <td style="text-align: center">{{ $algo[0] }}</td>
                                <td style="text-align: center">{{ $algo[1] }}</td>
                                <td style="text-align: center">{{ $algo[2] }}</td>
                                <td style="text-align: center">{{ $algo[1]*$algo[2] }}</td>
                                <td style="text-align: center"><button type="button"  wire:click="downinstallation({{ $algo[3] }}, '{{ $algo[2] }}', '{{ $algo[1] }}')" class="btn btn-danger btn-sm">Quitar</button></td>
                              </tr>
                              @endforeach
                              <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: center">Total</td>
                                <td style="text-align: center">{{ $total }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button"  wire:click="storepedido()" class="btn btn-primary">Crear Compra</button>
                </div>
              </form>
            </div>
            <div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                <form wire.submit.prevent="addmaterial">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Instalación seleccionada</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
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
                          <p><label>Codigo: </label> {{$codei}}</p>
                        </div>
                        <div class="form-group">
                          <p><label>Descripción: </label> {{$descriptioni}}</p>
                        </div>
                        <div class="form-group">
                        <label>Cantidad:</label>
                        <input wire:model.defer="cant" type="number">
                    </div>
                    <div class="modal-footer">
                      <button type="submit" wire:click.prevent="addinstallation()" class="btn btn-primary btn-sm" >Agregar</button>
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                  </div>
                </form>
                </div>
              </div>
</div>