
<div class="card card-primary">
                <div class="card-body">
                  <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Matereriales registradas en la revisión:</font></font></label>
                    
                          <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                <th style="text-align: center">Codigo Material</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Cantidad</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                           
                              @forelse($detailslist as $detail)
                                <tr>
                                  <td style="text-align: center">{{ $mat[$detail->material_id]['code']}}</td>
                                  <td style="text-align: center">{{ $mat[$detail->material_id]['description']}}</td>
                                  <td style="text-align: center">{{ $detail->amount }}</td>
                                  <td style="text-align: center">
                                    <button type="submit"  method="POST" wire:click="updatecantidad({{ $detail->id }})" class="btn btn-primary btn-xs">Modificar</button>
                                    <button type="submit"  wire:click="borradetail({{ $detail->id }})" class="btn btn-danger btn-xs">Borrar</button>
                                  </td>
                                </tr> 
                              @empty
                                  <tr class="text-center">
                                    <td colspan="4" class="py-3 italic">No hay información</td>
                                  </tr>
                              @endforelse

                            </tbody>
                          </table>
                          @if($upca==true)
                            <div class="card-body table-responsive p-0">
                                  <table class="table table-hover text-nowrap">
                                    <thead>
                                      <tr>
                                        <th style="text-align: center">Codigo Material</th>
                                        <th style="text-align: center">Descripción</th>
                                        <th style="text-align: center">Cantidad</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td style="text-align: center">{{ $code }}</td>
                                        <td style="text-align: center">{{ $descripcion }}</td>
                                        <td style="text-align: center"><input wire:model="amount" type="number"></td>
                                        <td><button type="button"  wire:click="editdetail()" class="btn btn-success btn-xs">Agregar</button><button type="button"  wire:click="cancelarupdetail()" class="btn btn-danger btn-xs">Cancelar</button></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                            @endif
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
                  <div class="card-footer">
                    <button type="submit"  wire:click="store()" class="btn btn-primary">Guardar Cambios</button>
                    <button type="submit"  wire:click="cancelar()" class="btn btn-primary">Cancelar</button>
                  </div>
</div>
