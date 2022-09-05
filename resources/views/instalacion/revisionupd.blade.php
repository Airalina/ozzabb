<div>
    <button wire:click="explora({{ $installation_id }})" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card card-primary">
                <div class="card-body">
                  <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Materiales registradas en la revisión:</font></font></label>
                    
                          <table class="table table-hover table-sm">
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
                                    <button type="submit"  method="POST" wire:click="updatecantidad({{ $detail->id }})" class="btn btn-primary btn-sm">Modificar</button>
                                    <button type="submit"  wire:click="borradetail({{ $detail->id }})" class="btn btn-danger btn-sm">Borrar</button>
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
                                  <table class="table table-hover table-sm">
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
                                        <td><button type="button"  wire:click="editdetail()" class="btn btn-success btn-sm">Agregar</button><button type="button"  wire:click="cancelarupdetail()" class="btn btn-danger btn-xs">Cancelar</button></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                            @endif
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
                          <table class="table table-hover table-sm">
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
                                <td><button type="button"  wire:click="selectmaterial({{ $material->id }})" class="btn btn-success btn-sm">Seleccionar</button></td>
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
                          <h3 class="card-title">Materiales agregados:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover table-sm">
                            <thead>
                            <tr>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Cantidad</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                              @if(!empty($details))
                                @foreach($details as $detail)  
                                <tr>
                                  <td style="text-align: center">{{ $detail[0]}}</td>
                                  <td style="text-align: center">{{ $detail[1] }}</td>
                                  <td style="text-align: center">{{ $detail[2]}}</td>
                                  <td style="text-align: center"><button type="button"  wire:click="downmaterial({{ $detail[3] }})" class="btn btn-danger btn-sm">Quitar</button></td>
                                </tr>
                                @endforeach
                              @endif
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                  <div class="card-footer">
                    <button type="submit"  wire:click="store()" class="btn btn-primary">Guardar Cambios</button>
                    <button type="submit"  wire:click="cancelar()" class="btn btn-primary">Cancelar</button>
                  </div>

                <div wire:ignore.self class="modal" id="form" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <form wire.submit.prevent="addmaterial">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Material</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                              <p><label>Codigo: </label> {{$codem}}</p>
                            </div>
                            <div class="form-group">
                              <p><label>Descripción: </label> {{$descriptionm}}</p>
                            </div>
                            <div class="form-group">
                            <label>Cantidad:</label>
                            <input wire:model.defer="amount" type="number">
                        </div>
                        <div class="modal-footer">
                          <button type="submit" wire:click.prevent="addmaterial()" class="btn btn-primary btn-sm" >Agregar</button>
                          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
</div>
