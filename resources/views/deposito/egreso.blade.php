<div class="card-tools">
    <div class="card-header">
        <h6 class="card-title">Deposito: {{ $name }} </h6><br>
        <h6 class="card-title">Ubicación: {{ $location }} </h6><br>
        <h6 class="card-title">Propósito: {{ $purpose}} </h6><br>
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
                            <div class="form-group">
                                <label for="exampleInputEmail1">Estado</label>
                                <input class="form-control form-control-sm" type="text" wire:model="sta" placeholder="Ingrese nombre del deposito">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Usuario que retira</label>
                                <input class="form-control form-control-sm" type="email" wire:model="user" placeholder="Ingrese ubicación del depósito">
                            </div>
            </div>
            <div class="row">
            @if($select==false)
                    <div class="col-7">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Seleccione material a ser retirado:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                              <tr>
                                <th style="text-align: center">Id</th>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Descripción</th>
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
                                <td style="text-align: center">{{ $material->amount }}</td>
                                <td><button type="button"  wire:click="retiromaterial({{ $material->id }})" class="btn btn-success btn-xs">Retirar</button></td>
                              </tr>
                            @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                @else
                 <div class="col-7">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Material a ser retirado:</h3>
                          <br>
                          <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="searchmaterialdepo" type="text" class="form-control form-control-xs float-right" placeholder="Buscar material...">
                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                              <tr>
                                <th style="text-align: center">Id</th>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Cantidad en deposito</th>
                                <th style="text-align: center">Cantidad a retirar</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td style="text-align: center">{{ $material_id }}</td>
                                <td style="text-align: center">{{ $material_code }}</td>
                                <td style="text-align: center">{{ $material_description }}</td>
                                <td style="text-align: center">{{ $amount }}</td>
                                <td style="text-aling: center"><input type="number" wire:model="egreso"></td>
                                <td><button type="button"  wire:click="egresomaterial" class="btn btn-success btn-xs">Retirar</button></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      <div class="form-group">
                                  <label for="exampleInputEmail1">Destino de material</label>
                                  <input class="form-control form-control-sm" type="text" wire:model="destination" placeholder="Ingrese destino del material">
                      </div>
                    </div>
                @endif
                    <div class="col-5">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Materiales a ser retirados:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th style="text-align: center">Código</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Cantidad a retirar</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($details as $detail)
                              <tr>
                                <td style="text-align: center">{{$detail[6]}}</td>
                                <td style="text-align: center">{{$detail[7]}}</td>
                                <td style="text-align: center">{{$detail[2]}}</td>
                                <td style="text-align: center"><button type="button"  wire:click="downegreso({{ $detail[4] }})" class="btn btn-danger btn-xs">-</button></td>
                              </tr>
                            @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <div class="card-footer">
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                        <td><button wire:click="toexplora()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
              </div>
        </div>
</div>

