@if($update==true)
  <div> 
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
  </div>
  <br>
@endif
<div class="card card-primary">
              @if($update==false)
              <div class="card-header">
                <h3 class="card-title">Nuevo pedido del cliente: {{ $namecust }}</h3>
              </div>
              @else
              <div class="card-header">
                <h3 class="card-title">Ficha de actualización del pededido con codigo: {{$order_id}}/2021</h3></br>
                <h3 class="card-title"> Cliente: {{ $namecust }}</h3>
              </div>
              @endif
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    @if($update==true)
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fecha de entrega estimada: {{ ($deadline)->format("d/m/Y") }}</font></font></label>&nbsp&nbsp<button type="button"  wire:click="nuevafecha()" class="btn btn-success btn-xs">Ingresar otra fecha</button><br>
                      @if($nuevafecha==true)
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nueva Fecha:</font></font></label>
                      <div class="row">
                        <div class="col-3">
                          <div class="input-group">
                            <input type="date" wire:model="deadline1" class="form-control form-control-sm">&nbsp&nbsp<button type="button"  wire:click="cancelarfecha()" class="btn btn-danger btn-xs">Cancelar</button>
                          </div>
                        </div>  
                      </div>
                      @endif
                    @else
                        <h4><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fecha de entrega estimada:</font></font></h4>
                        <div class="row">
                          <div class="col-4">
                              <input type="date" wire:model="deadline" class="form-control form-control-sm" placeholder="dd/mm/AAAA" >
                          </div>
                        </div>
                    @endif
                    <br>
                <label>Domicilio administrativo del cliente: {{$customer->domicile_admin}}</label>
                <br>
                <label>Domicilio de entrega:</label>
                <br>
                <div class="card-body p-0">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th style="text-align: center">Calle</th>
                        <th style="text-align: center">Numero</th>
                        <th style="text-align: center">Localidad</th>
                        <th style="text-align: center">Provincia</th>
                        <th style="text-align: center">País</th>
                        <th style="text-align: center">Codigo Postal</th>
                        <th style="text-align: center"> @if($addaddress==false)<button type="button" wire:click="addaddress()" class="btn btn-primary btn-xs"> Otra Dirección</button>@endif</th>
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
                        <td style="text-align: center"><button type="button" wire:click="selectadd({{ $addres->id }})" class="btn btn-success btn-xs"> Seleccionar</button></td>
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
                        <td style="text-align: center"><button type="button" wire:click="cancelaradd({{ $customer->id }})" class="btn btn-danger btn-xs">Cancelar Selección</button></td>
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
                        <td style="text-align: center"></td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
                    @if($update==true)
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Instalaciones registradas en el pedido:</font></font></label>
                    
                          <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                <th style="text-align: center">Codigo instalación</th>
                                <th style="text-align: center">Precio Unitario U$D</th>
                                <th style="text-align: center">Cantidad</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            @forelse($detailcollect as $install)
                              <tr>
                                <td style="text-align: center">{{ $install->material_id }}</td>
                                <td style="text-align: center">{{ $install->unit_price_usd }}</td>
                                <td style="text-align: center">{{ $install->cantidad }}</td>
                                <td style="text-align: center">
                                  <button type="button"  wire:click="updatecantidad({{ $install->id }})" class="btn btn-primary btn-xs">Modificar</button>
                                </td>
                              </tr> 
                            @empty
                                <tr class="text-center">
                                  <td colspan="4" class="py-3 italic">No hay información</td>
                                </tr>
                            @endforelse
                                @if($installid==true)
                                <div class="card-body table-responsive p-0">
                                  <table class="table table-hover text-nowrap">
                                    <thead>
                                      <tr>
                                        <th style="text-align: center">Codigo instalación</th>
                                        <th style="text-align: center">Precio Unitario U$D</th>
                                        <th style="text-align: center">Cantidad</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td style="text-align: center">{{ $codinstall }}</td>
                                        <td style="text-align: center">{{$upusd }}</td>
                                        <td style="text-align: center"><input wire:model="cantidad" type="number"></td>
                                        <td><button type="button"  wire:click="nuevacantidad({{ $detailup }})" class="btn btn-success btn-xs">Agregar</button><button type="button"  wire:click="cancelacantidad()" class="btn btn-danger btn-xs">Cancelar</button></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              @endif

                            </tbody>
                          </table>
                    @endif 
                    <div class="row">
                    <div class="col-6">
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
                          <table class="table table-hover text-nowrap">
                            <thead>
                              <tr>
                                <th style="text-align: center">Cod.</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">P/U U$D</th>
                                <th style="text-align: center">Cantidad</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            @forelse($installations as $install)
                              <tr>
                                <td style="text-align: center">{{ $install->code }}</td>
                                <td style="text-aling: center">{{ $install->description}}</td>
                                <td style="text-align: center">{{ $install->usd_price }}</td>
                                <td style="text-align: center"><input wire:model="cant" size="4" type="number"></td>
                                <td><button type="button"  wire:click="addinstallationup({{ $install->id }})" class="btn btn-success btn-xs">Agregar</button></td>  
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
                    </div>
                    <div class="col-6">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Instalaciones agregadas:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
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
                                <td style="text-align: center"><button type="button"  wire:click="downinstallation({{ $algo[3] }}, '{{ $algo[2] }}', '{{ $algo[1] }}')" class="btn btn-danger btn-xs">-</button></td>
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
                  </div>
                </div>
                <!-- /.card-body -->
                @if($update==true)
                  <div class="card-footer">
                    <button type="submit"  wire:click="editar({{ $order_id }})" class="btn btn-primary">Guardar Cambios</button>
                  </div>
                @else
                  <div class="card-footer">
                    <button type="submit"  wire:click="storepedido()" class="btn btn-primary">Crear Compra</button>
                  </div>
                @endif
              </form>
            </div>
</div>
