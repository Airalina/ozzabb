<div>
  <button wire:click="toexplora()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
    Volver</button>
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
  <div class="card card-primary">
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
      <form>
        <div class="card-body">
          <h5>Datos de egreso</h5>
          <br>
          <div class="col">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Seleccione el destino:</h3>
                <br>
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input wire:model="searchdeposito" type="text" class="form-control form-control-xs float-right"
                    placeholder="Buscar deposito...">
                </div>
              </div>
              @if ($searchdeposito != '')
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm">
                  <thead>
                    <tr>
                      <th style="text-align: center">id</th>
                      <th style="text-align: center">Nombre</th>
                      <th style="text-align: center">Descripción</th>
                      <th style="text-align: center">Tipo</th>
                      <th style="text-align: center">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($deposits as $deposit)
                    <tr>
                      <td style="text-align: center">{{ $deposit->id }}
                      </td>
                      <td style="text-align: center">
                        {{ $deposit->name }}</td>
                      <td style="text-align: center">
                        {{ $deposit->description }}</td>
                      <td style="text-align: center">
                        @if($deposit->type==1)
                        Almacen
                        @elseif($deposit->type==2)
                        Producción
                        @elseif($deposit->type==3)
                        Ensamblados
                        @elseif($deposit->type==4)
                        Expedición
                        @endif
                      </td>
                      <td style="text-align: center"><button type="button"
                          wire:click="selectdeposit({{ $deposit->id }})" class="btn btn-success btn-sm">Agregar</button>
                      </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                      <td colspan="4" class="py-3 italic">No hay
                        información
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              @endif
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @if (!empty($depo_destino))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Depósito destino:</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm">
                  <thead>
                    <tr>
                      <th style="text-align: center">id</th>
                      <th style="text-align: center">Nombre</th>
                      <th style="text-align: center">Descripción</th>
                      <th style="text-align: center">Tipo</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="text-align: center">{{ $depo_destino->id }}
                      </td>
                      <td style="text-align: center">
                        |{{ $depo_destino->name }}</td>
                      <td style="text-align: center">
                        {{ $depo_destino->description }}</td>
                      <td style="text-align: center">
                        @if($depo_destino->type==1)
                        Almacen
                        @elseif($depo_destino->type==2)
                        Producción
                        @elseif($depo_destino->type==3)
                        Ensamblados
                        @elseif($depo_destino->type==4)
                        Expedición
                        @endif
                      </td>
                      <td style="text-align: center"><button type="button"
                          wire:click="downdeposit({{ $depo_destino->id }})"
                          class="btn btn-danger btn-sm">Quitar</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Responsable de egreso:</label>
            <div class="row">
              <div class="col-4">
                <input type="text" wire:model="name_egress" class="form-control form-control-sm" style="width: auto"
                  placeholder="Responsable de egreso">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Responsable de recibir:</label>
            <div class="row">
              <div class="col-4">
                <input type="text" wire:model="name_receive" class="form-control form-control-sm" style="width: auto"
                  placeholder="Responsable de recibir">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Fecha</label>
            <div class="row">
              <div class="col-4">
                <input type="date" wire:model="date" class="form-control form-control-sm" style="width: auto"
                  placeholder="dd/mm/AAAA">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Hora</label>
            <div class="row">
              <div class="col-4">
                <input type="time" wire:model="hour" style="width: auto" class="form-control form-control-sm"
                  placeholder="">
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <div class="form-group">
              <label for="selection">Seleccione el tipo de producto a egresar:</label>
              <select class="form-control form-control-sm col-3" wire:model="selection" id="selection" {{$disabled}}>
                  <option value="">Selecciona un tipo de producto</option>
                  <option value="Materiales">Materiales</option>
                  <option value="Ensamblados">Ensamblados</option>
              </select>
          </div>
          @if ($selection != '')
            @if ($explora_depo->type == 3 || $selection == 'Ensamblados')
            <h3 class="card-title">Seleccione ensamblado a ser retirado:</h3>
            <br>
            <div class="input-group input-group-sm" style="width: 150px;">
              @if (!empty($depo))
              <input wire:model="searchensambladodepo" type="text" class="form-control form-control-xs float-right"
                placeholder="Buscar ensamblado...">
              @endif
            </div>
            @else
            <h3 class="card-title">Seleccione material a ser retirado:</h3>
            <br>
            <div class="input-group input-group-sm" style="width: 150px;">
              @if (!empty($depo))
              <input wire:model="searchmaterialsdepo" type="text" class="form-control form-control-xs float-right"
                placeholder="Buscar material...">
              @endif
            </div>
            @endif
            <br>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th style="text-align: center">Id</th>
                  @if ($selection == 'Materiales')
                  <th style="text-align: center">Código</th>
                  <th style="text-align: center">Descripción</th>
                  <th style="text-align: center">Presentación</th>
                  @else
                  <th style="text-align: center">Descripción</th>
                  @endif
                  <th style="text-align: center">Cantidad en deposito</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @if ($selection == 'Materiales')
                @foreach($materials_deposits as $material)
                <tr>
                  <td style="text-align: center">{{ $material->id }}</td>
                  <td style="text-align: center">{{ $material->code }}</td>
                  <td style="text-align: center">{{ $material->description }}</td>
                  <td style="text-align: center">
                    @foreach ($material->depositmaterials()->where('warehouse_id',
                    $deposito_id)->where('is_material',1)->groupBy('presentation')->get() as
                    $presentation)
                    <div class="row justify-content-center">
                      <div class="col-4 border"> {{ $presentation->presentation }} </div>
                    </div>
                    @endforeach
                  </td>
                  <td style="text-align: center">
                    @foreach ($material->depositmaterials()->where('warehouse_id',
                    $deposito_id)->where('is_material',1)->select('presentation','material_id', DB::raw('SUM(amount) as
                    total'))->groupBy('presentation')->get() as $amount)
                    <div class="row justify-content-center">
                      <div class="col-4 border"> {{ $amount->total }} </div>
                    </div>
                    @endforeach
                  </td>
                  <td style="text-align: center"><button type="button" wire:click="retiromaterial({{ $material->id }})"
                      class="btn btn-success btn-sm">Retirar</button></td>
                </tr>
                @endforeach
                @elseif($selection == 'Ensamblados')
                
                @foreach($ensamblados_deposits as $ensamblado)
               
                <tr>
                  <td style="text-align: center">{{ $ensamblado->id }}</td>
                  <td style="text-align: center">{{ $ensamblado->description }}</td>
                  <td style="text-align: center">
                    {{ $ensamblado->depositmaterials()->where('warehouse_id',
                    $deposito_id)->where('is_material',0)->select('material_id', DB::raw('SUM(amount) as
                    total'))->groupBy('material_id')->first()->total }}
                  </td>
                  <td style="text-align: center"><button type="button"
                      wire:click="retiroensamblado({{ $ensamblado->id }})"
                      class="btn btn-success btn-sm">Retirar</button></td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            @if ($explora_depo->type == 3 || $selection == 'Ensamblados')
            <h3 class="card-title">Ensamblados a ser retirados:</h3>
            @else
            <h3 class="card-title">Materiales a ser retirados:</h3>
            @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th style="text-align: center">Código</th>
                  <th style="text-align: center">Descripción</th>
                  @if ($selection == 'Materiales')
                  <th style="text-align: center">Presentación</th>
                  @endif
                  <th style="text-align: center">Cantidad a retirar</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($details as $detail)
                <tr>
                  <td style="text-align: center">{{$detail[0]}}</td>
                  <td style="text-align: center">{{$detail[1]}}</td>
                  @if ($selection == 'Materiales')
                  <td style="text-align: center">{{$detail[5]}}</td>
                  @endif
                  <td style="text-align: center">{{$detail[2]}}</td>
                  <td style="text-align: center"><button type="button" wire:click="downegreso({{ $detail[3] }})"
                      class="btn btn-danger btn-sm">Quitar</button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card-footer">
          <td><button wire:click="store()" type="button" class="btn btn-primary">Guardar </button></td>
          <td><button wire:click="toexplora()" type="button" class="btn btn-primary">Cancelar</button></td>
        </div>
    </div>
  </div>
</div>
</form>
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
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          @if ($selection == 'Materiales')
          <div class="form-group">
            <p><label>Codigo: </label> {{$codem}}</p>
          </div>
          <div class="form-group">
            <p><label>Descripción: </label> {{$descriptionm}}</p>
          </div>
          @if (isset($materials_presentation))
          <div class="form-group col-3">
            <label>Presentación:</label>
            <select wire:model.defer="presentation" id="presentation" wire:change="amount({{ $material_id }})"
              class="form-control form-control-sm">
              <option selected>Seleccione una presentación</option>
              @foreach ($materials_presentation as $index => $presentation)
              <option value="{{ $presentation->presentation }}"> {{ $presentation->presentation }} </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <p><label>Cantidad disponible: </label> {{ isset($materials_amount) ? $materials_amount["total"] : '' }}
            </p>
          </div>
          @endif
          <div class="form-group">
            <label>Cantidad a retirar: </label>
            <input wire:model.defer="egreso" type="number">
          </div>
          @else
          <div class="form-group">
            <p><label>Descripción: </label> {{$descriptiona}}</p>
          </div>
          <div class="form-group">
            <p><label>Cantidad: </label> {{$assembled_amount}}</p>
          </div>
          <div class="form-group">
            <label>Cantidad a retirar: </label>
            <input wire:model.defer="egreso" type="number">
          </div>
          @endif
        </div>
        <div class="modal-footer">
          @if ($selection == 'Materiales')
          <button type="submit" wire:click.prevent="egresomaterial()" class="btn btn-primary btn-sm">Agregar</button>
          @else
          <button type="submit" wire:click.prevent="egresoensamblado()" class="btn btn-primary btn-sm">Agregar</button>
          @endif
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>