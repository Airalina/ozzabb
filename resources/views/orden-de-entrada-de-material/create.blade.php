<div>
        <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
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
                        @if($modo=="Sin orden de compra")
                          <div class="form-group">
                              <label>Origen</label>
                              <input class="form-control form-control-sm" type="text" wire:model="origen" style="width: 300px;" placeholder="Ingrese origen del material a ser ingresado">
                          </div>
                          <div class="form-group">
                              <label>Causa</label>
                              <input class="form-control form-control-sm" type="text" wire:model="causa" style="width: 300px;" placeholder="Ingrese causa por la cual ingresa los materiales">
                          </div>
                        @elseif($modo=="Con orden de compra")
                        <div class="form-group">
                              <label>N° de remito:</label>
                              <input class="form-control form-control-sm" type="text" wire:model="follow" style="width: 300px;"  placeholder="Ingrese N° remito">
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" wire:model="date" class="form-control form-control-sm" style="width: auto" placeholder="dd/mm/AAAA" >
                        </div>
                        <div class="form-group">
                            <label>Hora</label>
                                    <input type="time" wire:model="hour" class="form-control form-control-sm" style="width: auto" placeholder="" >
                        </div>
                        @if($modo=="Sin orden de compra")
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
                                <table class="table table-hover table-sm">
                                  <thead>
                                    <tr>
                                      <th style="text-align: center">Codigo</th>
                                      <th style="text-align: center">Descripción</th>
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
                                      <td style="text-align: center"><input wire:model="presentation" type="number" style="width: 100px;"></td>
                                      <td style="text-align: center"><input wire:model="amount" type="number" style="width: 100px;"></td>
                                      <td style="text-align: center">
                                          <select class="form-control select2 select2-hidden-accessible" wire:model="nombre_deposito" style="width: 100%;">
                                              <option selected="selected" ></option>
                                              @foreach($depositos as $deposito)
                                              <option >{{$deposito->name}}</option>
                                              @endforeach
                                          </select>
                                      </td>
                                      <td><button type="button"  wire:click="addmaterial({{ $material->id }})" class="btn btn-success btn-sm">Agregar</button></td>
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
                                <table class="table table-hover table-sm">
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
                                      <td style="text-align: center"><button type="button"  wire:click="downmaterial({{ $detail[3] }})" class="btn btn-danger btn-sm">-</button></td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                              <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            @elseif($modo=="Con orden de compra")
                            <div class="card">
                              <div class="card-header">
                                <h3>Detalle de orden de compra: {{$buy_order_id}}</h3>
                              </div>
                              @if($ingresa==false)
                              <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                  <thead>
                                    <tr>
                                      <th style="text-align: center">Código material</th>
                                      <th style="text-align: center">Descripción</th>
                                      <th style="text-align: center">N° orden de compra</th>
                                      <th style="text-align: center">Presentación</th>
                                      <th style="text-align: center">Cantidad requerida</th>>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($buyorderdetails as $order)
                                    <tr>
                                      <td style="text-align: center">{{ $order->materials->code}}</td>
                                      <td style="text-align: center">{{ $order->materials->description}}</td>
                                      <td style="text-align: center">{{ $order->buyorders->order_number }}</td>
                                      <td style="text-align: center">{{ $order->presentation}}</td>
                                      <td style="text-align: center">{{ $order->amount}}</td>
                                      <td style="text-align: center"><button type="button" wire:click="ingresomaterial({{$order->id}})" class="btn btn-success btn-sm"> Ingresar</button></td>
                                    </tr>
                                    @empty
                                      <tr class="text-center">
                                        <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                                      </tr>
                                    @endforelse
                                  </tbody>
                                </table>
                              </div>
                              <!-- /.card-body -->
                              @elseif($ingresa==true)
                                <div class="card-header">
                                  <h3 class="card-title">Detalle de orden de entrada: {{$entry_order_id}}</h3>
                                </div>
                                <div class="card-body table-responsive  p-0">
                                  <table class="table table-hover table-sm">
                                    <thead>
                                      <tr>
                                        <th style="text-align: center">Código Material</th>
                                        <th style="text-align: center">Descripción</th>
                                        <th style="text-aling: center">N° Deposito</th>
                                        <th style="text-align: center">Presentación</th>
                                        <th style="text-align: center">Cantidad requerida</th>
                                        <th style="text-align: center">Cantidad remito</th>
                                        <th style="text-align: center">Cantidad recibida</th>
                                        <th style="text-align: center">Diferencia</th>
                                        <th style="text-align: center">Sin Entrgar</th>
                                        <th style="text-align: center">Lote</th>
                                        <th></th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                      <td style="text-align: center">{{$code}}</td>
                                      <td style="text-align: center">{{$description}}</td>
                                      <td style="text-align: center">
                                          <select class="form-control select2 select2-hidden-accessible" wire:model="nombre_deposito" style="width: 100%;">
                                              <option selected="selected" ></option>
                                              @foreach($depositos as $deposito)
                                              <option >{{$deposito->name}}</option>
                                              @endforeach
                                          </select>
                                      </td>
                                      <td style="text-align: center">{{$presentation}}</td>
                                      <td style="text-align: center">{{$amount_requested}}</td>
                                      <td style="text-align: center"><input style="width: 100px" wire:model="amount_follow" type="number"></td>
                                      <td style="text-align: center"><input  style="width: 100px" wire:model="amount" type="number"></td>
                                      <td style="text-align: center">{{$amount_requested-$amount}}</td>
                                      <td style="text-align: center"><input style="width: 100px" wire:model="amount_undelivered" type="number"></td>
                                      <td style="text-align: center"><input style="width: 100px" wire:model="set" type="text"></td>
                                      <td style="text-align: center"><button type="button" wire:click="addmaterial({{$material_id}})" class="btn btn-success btn-sm"> Ingresar</button></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!-- /.card-body -->
                              @endif
                            </div>
                            <div class="card">
                              <div class="card-header">
                                <h3 class="card-title">Detalle de orden de entrada</h3>
                              </div>
                              <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                  <thead>
                                    <tr>
                                      <th style="text-align: center">Código Material</th>
                                      <th style="text-align: center">Descripción</th>
                                      <th style="text-aling: center">N° Deposito</th>
                                      <th style="text-align: center">Presentación</th>
                                      <th style="text-align: center">Cantidad recibida</th>
                                      <th style="text-align: center">Cantidad requerida</th>
                                      <th style="text-align: center">Cantidad remito</th>
                                      <th style="text-align: center">Diferencia</th>
                                      <th style="text-align: center">Sin Entrgar</th>
                                      <th></th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($details as $detail)
                                    <tr>
                                      <td style="text-align: center">{{ $detail[0]}}</td>
                                      <td style="text-align: center">{{ $detail[1] }}</td>
                                      <td style="text-align: center">{{ $detail[6] }}</td>
                                      <td style="text-align: center">{{ $detail[5]}}</td>
                                      <td style="text-align: center">{{ $detail[7]}}</td>
                                      <td style="text-align: center">{{ $detail[2]}}</td>
                                      <td style="text-align: center">{{ $detail[8]}}</td>
                                      <td style="text-align: center">{{ $detail[10]}}</td>
                                      <td style="text-align: center">{{ $detail[9]}}</td>
                                      <td style="text-align: center"><button type="button"  wire:click="downmaterial({{ $detail[3] }})" class="btn btn-danger btn-sm">-</button></td>
                                    </tr>
                                    @empty
                                      <tr class="text-center">
                                        <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                                      </tr>
                                    @endforelse
                                  </tbody>
                                </table>
                              </div>
                              <!-- /.card-body -->
                            </div>
                            @endif
                    <div class="card-footer">
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                        <td><button wire:click="volver()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
            </form>
</div>