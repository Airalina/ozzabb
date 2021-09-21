<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ingreso a deposito: {{$name}}</h3>
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
                        <h5>Datos de Ingreso</h5>
                        <br>    
                        <div class="form-group">
                            @if($select==false)
                                <label>Seleccione lo que desea ingresar:</label>
                                <select class="form-control select2 select2-hidden-accessible" wire:model="seleccion" style="width: 100%;">
                                    <option selected="selected" ></option>
                                    <option >Material</option>
                                    <option >Instalacion</option>
                                    <option >Ensamblado</option>
                                </select>
                            @endif
                        </div>
                        @if($seleccion=="Material")
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
                                <td><button type="button"  wire:click="addmateriald({{ $material->id }})" class="btn btn-success btn-xs">Agregar</button></td>
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
                                <td style="text-align: center"><button type="button"  wire:click="downmateriald({{ $detail[3] }})" class="btn btn-danger btn-xs">-</button></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                        @endif
                        @if($seleccion=="Ensamblado")
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-tools">
                                                <button wire:click="createassembled()" type="button" float="right" class="btn btn-info btn-sm">Agregar Ensamblado</button>
                                            </div>
                                            <h3 class="card-title">Seleccione ensamblado a ser agregado:</h3>
                                            <br>
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input wire:model="searchensamblados" type="text" class="form-control form-control-xs float-right" placeholder="Buscar instalación...">
                                            </div>
                                        </div>
                            <!-- /.card-header -->
                                        @if($searchensamblados!="" && $select==false && $seleccion="Ensamblado" )
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">Código</th>
                                                        <th style="text-align: center">Descripción</th>
                                                        <th style="text-align: center">Cantidad</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($ensamblados as $ensamble)
                                                        <tr>
                                                            <td style="text-align: center">{{ $ensamble->id }}</td>
                                                            <td style="text-align: center">{{ $ensamble->description }}</td>
                                                            <td style="text-align: center"><input wire:model="amount" type="number"></td>
                                                            <td><button type="button"  wire:click="addassembled({{ $ensamble->id }})" class="btn btn-success btn-xs">Agregar</button></td>
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
                                        @if($select==true  && $seleccion="Ensamblado")
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">Código</th>
                                                            <th style="text-align: center">Descripción</th>
                                                            <th style="text-align: center">Cantidad</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align: center">{{ $material_id }}</td>
                                                            <td style="text-align: center">{{ $description }}</td>
                                                            <td style="text-align: center">{{ $amount }} </td>
                                                            <td><button type="button"  wire:click="downmaterial()" class="btn btn-danger btn-xs">Quitar</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                        @endif
                                    @if($seleccion=="Instalacion")
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Seleccione instalacion a ser agregada:</h3>
                                            <br>
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input wire:model="searchinstallation" type="text" class="form-control form-control-xs float-right" placeholder="Buscar instalación...">
                                            </div>
                                        </div>
                            <!-- /.card-header -->
                                        @if($searchinstallation!="" && $select==false && $seleccion="Instalacion" )
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">Código</th>
                                                            <th style="text-align: center">Descripción</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($instalaciones as $instalacion)
                                                            <tr>
                                                                <td style="text-align: center">{{ $instalacion->code }}</td>
                                                                <td style="text-align: center">{{ $instalacion->description }}</td>
                                                                <td><button type="button"  wire:click="addinstallation({{ $instalacion->id }})" class="btn btn-success btn-xs">Agregar</button></td>
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
                                        @if($select==true  && $seleccion="Instalacion")
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">Código</th>
                                                            <th style="text-align: center">Descripción</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align: center">{{ $code }}</td>
                                                            <td style="text-align: center">{{ $description }}</td>
                                                            <td><button type="button"  wire:click="downinstallation()" class="btn btn-danger btn-xs">Quitar</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>                                                       
                                                        <tr>
                                                        <th>N° de revisión</th>
                                                        <th>Razón</th>
                                                        <th>Fecha de creación</th>
                                                        <th></th>
                                                        </tr>
                                                     </thead>   
                                                    <tbody>
                                                        @foreach($revisiones as $rev)
                                                            <tr>
                                                                <td>{{ $rev->number_version }}</td>
                                                                <td>{{ $rev->reason }}</td>
                                                                <td>{{ date('d-m-Y', strtotime($rev->create_date)) }}</td>                 
                                                                <td>
                                                                    @if($revi==false)
                                                                        <button type="button" wire:click="selectrevision({{$rev}})" class="btn btn-primary btn-xs"> Seleccionar</button>
                                                                    @else
                                                                        <button type="button" wire:click="downrevision()" class="btn btn-danger btn-xs"> Quitar</button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div>
                                                <label for="exampleInputEmail1">N° de serie: </label>
                                                <input type="text" wire:model="serial_number" class="form-control form-control-sm" placeholder="Ingrese N° de serie" >
                                            </div>
                                            <div>
                                                <label for="exampleInputEmail1">N° de orden de cliente: </label>
                                                <input type="number" wire:model="client_order_id" class="form-control form-control-sm" placeholder="Ingrese N° de orden de cliente" >
                                            </div>
                                        @endif
                                    @endif
                                    @if($seleccion=="Orden de ingreso de materiales")
                                            <div>
                                                <label for="exampleInputEmail1">N° de orden de ingreso: </label>
                                                <input type="number" wire:model="entry_order_id" class="form-control form-control-sm" placeholder="Ingrese N° deorden de ingreso" >
                                            </div>
                                            <div>
                                                <label for="exampleInputEmail1">N° de orden compra: </label>
                                                <input type="number" wire:model="buy_order_id" class="form-control form-control-sm" placeholder="Ingrese N° de orden de compra" >
                                            </div>
                                            <div>
                                                <label for="exampleInputEmail1">N° de remito: </label>
                                                <input type="text" wire:model="follow_number" class="form-control form-control-sm" placeholder="Ingrese N° de remito" >
                                            </div>
                                    @endif
                    </div>
                    <div class="card-footer">
                        <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
                        <td><button wire:click="toexplora()" type="button" class="btn btn-primary">Cancelar</button></td>
                    </div>
            </form>
</div>