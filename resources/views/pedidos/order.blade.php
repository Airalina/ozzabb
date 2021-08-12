<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Nuevo pedido del cliente: {{ $namecust }}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fecha de entrega estimada:</font></font></label>

                    <div class="input-group">
                      <input type="date" wire:model="deadline" class="form-control form-control-sm" placeholder="dd/mm/AAAA" >
                    </div>
                    <br>
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
                          <h3 class="card-title">Seleccione instalacion a ser agregada</h3>
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

                <div class="card-footer">
                  <button type="submit"  wire:click="storepedido()" class="btn btn-primary">Crear Compra</button>
                </div>
              </form>
            </div>
</div>
