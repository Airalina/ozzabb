<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registro de depósito</h3>
              </div>
              
            <form>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h5>Datos de depósito</h5>
                        <br>    
                        <div class="form-group">
                        <label>Modo de ingreso:</label>
                                <select class="form-control select2 select2-hidden-accessible" wire:model="modo" style="width: 100%;">
                                    <option selected="selected" ></option>
                                    <option >Con orden de compra</option>
                                    <option >Sin orden de compra</option>
                                </select>
                        </div>
                        @if($modo=="Sin orden de compra")
                        <div class="form-group">
                            <label for="exampleInputEmail1">Origen</label>
                            <input class="form-control form-control-sm" type="text" wire:model="origen" placeholder="Ingrese origen del material a ser ingresado">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Causa</label>
                            <input class="form-control form-control-sm" type="text" wire:model="causa" placeholder="Ingrese causa por la cual ingresa los materiales">
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="date" wire:model="date" class="form-control form-control-sm" placeholder="dd/mm/AAAA" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hora</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="time" wire:model="hour" class="form-control form-control-sm" placeholder="" >
                                </div>
                            </div>
                        </div>

                    <div class="col">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Seleccione material a ser agregado:</h3>
                          <br>
                          <div class="input-group input-group-sm" style="width: 150px;">
                            <input wire:model="searchmateriales" type="text" class="form-control form-control-xs float-right" placeholder="Buscar material...">
                          </div>
                        </div>
                        <!-- /.card-header -->
                        @if($searchmateriales!="")
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                              <tr>
                                <th style="text-align: center">Codigo</th>
                                <th style="text-align: center" >Descripción</th>
                                <th style="text-align: center">Presentación</th>
                                <th style="text-align: center">Cantidad</th>
                                <th style="text-align: center">Deposito</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                            @forelse($materiales as $material)
                              <tr>
                                <td style="text-align: center">{{ $material->code }}</td>
                                <td style="text-align: center" >{{ $material->description }}</td>
                                <td style="text-align: center"><input wire:model="presentation" type="number"></td>
                                <td style="text-align: center"><input wire:model="amount" type="number"></td>
                                <td style="text-align: center">
                                    <select class="form-control select2 select2-hidden-accessible" wire:model="nombre_deposito" style="width: 100%;">
                                        <option selected="selected" ></option>
                                        @foreach($depositos as $deposito)
                                        <option >{{$deposito->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
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
                    <div class="col">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Materiales agregados:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th style="text-align: center">Codigo</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Presentación</th>
                                <th style="text-align: center">Cantidad</th>
                                <th style="text-align: center">Deposito Id</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach($details as $detail)  
                              <tr>
                                <td style="text-align: center">{{ $detail[0] }}</td>
                                <td style="text-align: center">{{ $detail[1] }}</td>
                                <td style="text-align: center">{{ $detail[5] }}</td>
                                <td style="text-align: center">{{ $detail[2] }}</td>
                                <td style="text-align: center">{{ $detail[6] }}</td>
                                <td style="text-align: center"><button type="button"  wire:click="downmaterial({{ $detail[3] }})" class="btn btn-danger btn-xs">-</button></td>
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
                        <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
            </form>
</div>