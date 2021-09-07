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
                            <div class="row">
                                <div class="col-4">
                                    <input type="date" wire:model="date_admission" class="form-control form-control-sm" placeholder="dd/mm/AAAA" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-7">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Seleccione material a ser agregado:</h3>
                          <br>
                          <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="searchmateriales" type="text" class="form-control form-control-xs float-right" placeholder="Buscar instalación...">
                          </div>
                        </div>
                        <!-- /.card-header -->
                        @if($searchmateriales!="")
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                              <tr>
                                <th style="text-align: center">Codigo</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Cantidad</th>

                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            @forelse($materiales as $material)
                              <tr>
                                <td style="text-align: center">{{ $material->code }}</td>
                                <td style="text-align: center">{{ $material->description }}</td>
                                <td style="text-align: center"><input wire:model="amount" type="number"></td>
                                <td><button type="button"  wire:click="addmaterial({{ $material->id }})" class="btn btn-success btn-xs">Agregar</button></td>
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
                          <h3 class="card-title">Materiales agregadas:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th style="text-align: center">Codigo</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Cantidad</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach($details as $detail)  
                              <tr>
                                <td style="text-align: center">{{ $detail[0] }}</td>
                                <td style="text-align: center">{{ $detail[1] }}</td>
                                <td style="text-align: center">{{ $detail[2] }}</td>
                                <td style="text-align: center"><button type="button"  wire:click="downmaterial({{ $detail[3] }})" class="btn btn-danger btn-xs">-</button></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
                </div>
                    <div class="card-footer">
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                        <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
              </form>
</div>