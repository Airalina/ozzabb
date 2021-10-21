<div>
    <button wire:click="toexplora()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card-tools">
    <div class="card-header">
        <h6 class="card-title">Deposito: {{ $name }} </h6><br>
        <h6 class="card-title">Ubicación: {{ $location }} </h6><br>
        <h6 class="card-title">Descripción: {{ $descriptionw}} </h6><br>
        <h6 class="card-title">Fecha de creación: {{ date('d-m-Y', strtotime($create_date)) }} </h6><br>
        <br>
        <h6 class="card-title">Materiales en el deposito: </h6><br>
    </div>
    <div class="card card-primary card-tabs">
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
                            <h5>Datos de egreso</h5>
                            <br>
                            <div class="row">
                              <div class=col-md-3>    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Usuario que retira</label>
                                    <input class="form-control form-control-sm" type="email" wire:model="user" style="width: 300px" placeholder="Ingrese ubicación del depósito">
                                </div>
                              </div>
                              <div class=col-md-4>    
                                <div class="form-group">
                                      <label for="exampleInputEmail1">Destino de material</label>
                                      <select class="form-control form-control-sm select2 select2-hidden-accessible" wire:model="destination" style="width: auto">
                                        <option selected="selected" ></option>
                                        <option >Almacén</option>
                                        <option >Producción</option>
                                        <option >Expedición</option>
                                     </select>
                                </div>
                              </div>
                            </div>
            </div>
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Seleccione material a ser retirado:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover table-sm">
                            <thead>
                              <tr>
                                <th style="text-align: center">Id</th>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Presentación</th>
                                <th style="text-align: center">Cantidad en deposito</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($materialesdepo as $material)
                              <tr>
                                <td style="text-align: center">{{ $material->material_id }}</td>
                                <td style="text-align: center">{{ $material->materials->code }}</td>
                                <td style="text-align: center">{{ $material->materials->description }}</td>
                                <td style="text-align: center">{{ $material->presentation }}</td>
                                <td style="text-align: center">{{ $material->amount }}</td>
                                <td><button type="button"  wire:click="retiromaterial({{ $material->id }})" class="btn btn-success btn-sm">Retirar</button></td>
                              </tr>
                            @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Materiales a ser retirados:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover table-sm">
                            <thead>
                            <tr>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Presentación</th>
                                <th style="text-align: center">Cantidad a retirar</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($details as $detail)
                              <tr>
                                <td style="text-align: center">{{$detail[6]}}</td>
                                <td style="text-align: center">{{$detail[7]}}</td>
                                <td style="text-align: center">{{$detail[9]}}</td>
                                <td style="text-align: center">{{$detail[2]}}</td>
                                <td style="text-align: center"><button type="button"  wire:click="downegreso({{ $detail[4] }})" class="btn btn-danger btn-sm">Quitar</button></td>
                              </tr>
                            @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    <div class="card-footer">
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                        <td><button wire:click="toexplora()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
              </div>
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
                          <p> <label>Presentación: </label> {{$presentation}}</p>
                        </div>
                        <div class="form-group">
                          <p> <label>Cantidad: </label> {{$amount}}</p>
                        </div>
                        <div class="form-group">
                          <label>Cantidad a retirar: </label>
                          <input wire:model.defer="egreso" type="number">
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" wire:click.prevent="egresomaterial()" class="btn btn-primary btn-sm" >Agregar</button>
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                  </div>
                </form>
                </div>
              </div>
</div>

