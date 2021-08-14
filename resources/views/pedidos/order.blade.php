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
                    <div class="col-7">
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
                                <th style="text-align: center">Codigo instalación</th>
                                <th style="text-align: center">Precio Unitario U$D</th>
                                <th style="text-align: center">Cantidad</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            @forelse($installations as $install)
                              <tr>
                                <td style="text-align: center">{{ $install->code }}</td>
                                <td style="text-align: center">{{ $install->usd_price }}</td>
                                <td style="text-align: center"><input wire:model="cant" type="number"></td>
                                <td><button type="button"  wire:click="addinstallation({{ $install->id }})" class="btn btn-success btn-xs">Agregar</button></td>
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
                    <div class="col-5">
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
