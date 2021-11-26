<div>
    <button wire:click="backlist()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div><br>
<div>
    <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title">Pedidos de clientes</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <form>
                <div class="card-header">
                    <h3 class="card-title">Seleccione pedido a ser agregado:</h3>
                    <br />

                    <div wire:ignore class="input-group input-group-sm" style="width: 130px">
                        <input wire:model="search" type="text" class="form-control form-control-xs float-right" placeholder="Buscar pedido..." />
                    </div>

                </div>
                @if ($search != '')

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Nombre del cliente</th>
                                     <th style="text-align: center">Fecha estimada</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $orderr)
                                    <tr>
                                        <td style="text-align: center">{{ $orderr->id }}/2021</td>
                                        <td style="text-align: center">
                                            {{ $orderr->customer_name }}
                                        </td>
                                        <td style="text-align: center">
                                            {{ $orderr->deadline->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <div>
                                                <button type="button" wire:click="addorder({{ $orderr->id }})"
                                                    class="btn btn-success btn-sm">
                                                    Agregar
                                                </button>
                                            </div>
                                        </td>
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

            </form>
        </div>
        </div>
        <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <div class="card-body table-responsive">
            <form>
                <div class="card-header">
                    <h3 class="card-title">Pedidos de clientes seleccionados:</h3>
                    <br>
                </div>
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Nombre del cliente</th>
                                    <th style="text-align: center">Fecha estimada de entrega</th>
                                    <th style="text-align: center">Estado</th>
                                    <th style="text-align: center">Fecha de pedido</th>
                                    <th style="text-align: center">Tiene compras</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ordenes as $orden)
                                    <tr>
                                        <td style="text-align: center">{{ $orden['id'] }}/{{ date('Y', strtotime($orden['date']))}}</td>
                                        <td style="text-align: center">{{ $orden['customer_name'] }}</td>
                                        <td style="text-align: center">{{ date('d/m/Y', strtotime($orden['date']))}}</td>
                                        @switch($orden['order_state'])
                                                @case(1):
                                                    <td style="text-align: center">Nuevo</td>
                                                    @break
                                                @case(2):
                                                    <td style="text-align: center">Confirmado</td>
                                                    @break
                                                @case(3):
                                                    <td style="text-align: center">Rechazado</td>
                                                    @break
                                                @case(4):
                                                    <td style="text-align: center">Demorado</td>
                                                    @break
                                                @case(5):
                                                    <td style="text-align: center">En producción</td>
                                                    @break
                                                @case(6):
                                                    <td style="text-align: center">En depósito</td>
                                                    @break
                                                @case(7):
                                                    <td style="text-align: center">Cancelado</td>
                                                    @break           
                                        @endswitch
                                        <td style="text-align: center">{{ date('d/m/Y', strtotime($orden['date']))}}</td>
                                        @switch($orden['buys'])
                                                @case(null):
                                                    <td style="text-align: center">No</td>
                                                    @break
                                                @case(1):
                                                    <td style="text-align: center">No</td>
                                                    @break
                                                @case(2):
                                                    <td style="text-align: center">Si</td>
                                                    @break           
                                        @endswitch
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="100%" class="py-3 italic">No hay ordenes agregadas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </form>
        </div>
        </div>
        <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <div class="card-body table-responsive">
            <form>
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title"> Materiales requeridos para los pedidos seleccionados: </h3>
                        </div>
                        <div class="col-md-4">
                            <button type="button" wire:click.prevent="buscamaterial()" class="btn btn-success btn-sm" style="float: right">Agregar material a la orden</button>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Código</th>
                                    <th style="text-align: center">Descripción</th>
                                    <th style="text-align: center">Stock</th>
                                    <th style="text-align: center">Stock en tránsito</th>
                                    <th style="text-align: center">Stock requerido</th>
                                    <th style="text-align: center">Proveedor</th>
                                    <th style="text-align: center">Presentación</th>
                                    <th style="text-align: center">Cantidad</th>
                                    <th style="text-align: center">Cantidad total</th>
                                    <th style="text-align: center">P/U U$D</th>
                                    <th style="text-align: center">Subtotal U$D</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchasings as $purchasing)
                                    <tr>
                                        <td style="text-align: center">{{ $purchasing[1] }}</td>
                                        <td style="text-align: center">{{ $purchasing[2] }}</td>
                                        <td style="text-align: center">{{ $purchasing[3] }}</td>
                                        <td style="text-align: center">{{ $purchasing[4] }}</td>
                                        <td style="text-align: center">{{ $purchasing[5] }}</td>
                                        <td style="text-align: center">{{ $purchasing[10] }}</td>
                                        <td style="text-align: center">{{ $purchasing[6] }}</td>
                                        <td style="text-align: center">{{ $purchasing[7] }}</td>
                                        <td style="text-align: center">{{ $purchasing[8] }}</td>
                                        <td style="text-align: center">{{ $purchasing[9] }}</td>
                                        <td style="text-align: center">{{ $purchasing[11] }}</td>
                                        <td style="text-align: center"><button type="button" wire:click="buy({{$purchasing[1]}})"class="btn btn-success btn-sm">Comprar</button></td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="100%" class="py-3 italic">No hay ordenes agregadas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                <label>Subtotal</label>
                <p>{{ $subtotal }}</p>
                <label>IVA(%)</label>
                <input class="form-control form-control-sm" type="number" wire:model="iva" 
                    placeholder="IVA" style="width: 60px;">
                <label>Precio total</label>

                <p>{{$total_price}}</p>

                <div class="form-group">
                    <button wire:click="save()" type="button" class="btn btn-primary">Realizar pedido</button>
                </div>
            </form>
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
                          <p><label>Codigo: </label>{{$codem}}</p>
                        </div>
                        <div class="form-group">
                          <p><label>Descripción: </label>{{$descriptionm}}</p>
                        </div>
                        <div class="form-group">
                            <label>Seleccione un proveedor, para ver las presentaciones disponibles.</label>
                            <select class="form-control form-control-sm select2 select2-hidden-accessible" wire:model="proveedor_name" style="width: auto">
                                <option selected="selected"></option>
                                @foreach($proveedoresm as $proveedor)
                                    <option>{{$proveedor['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($proveedor_name!="")
                        <div class="form-group">
                            <label>Presentación:</label>
                            <select class="form-control form-control-sm select2 select2-hidden-accessible" wire:model="presentationm" style="width: auto">
                                <option selected="selected"></option>
                                @foreach($presentationsm as $presentation)
                                    <option>{{$presentation['unit']}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if($presentationm!=null)
                        <div class="form-group">
                            <label>Precio U$D:{{$precio->usd_price}}</label>
                            <br>
                            <label>Precio AR$:{{$precio->ars_price}}</label>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Cantidad:</label>
                            <input wire:model.defer="amount" type="number">
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" wire:click.prevent="buy_confirm()" class="btn btn-primary btn-sm" >Agregar</button>
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
        <div wire:ignore.self class="modal" id="formmaterial" tabindex="-1" role="dialog">
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
                        <div wire:ignore class="input-group input-group-sm" style="width: 130px">
                            <input wire:model="searchmaterial" type="text" class="form-control form-control-xs float-right" placeholder="Buscar material..." />
                        </div>
                        <div class="form-group">
                            <label>Materiales</label>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Código</th>
                                            <th style="text-align: center">Descripción</th>
                                            <th style="text-align: center">Stock</th>
                                            <th style="text-align: center">Stock en tránsito</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($materials as $material)
                                            <tr>
                                                <td style="text-align: center">{{ $material->code }}</td>
                                                <td style="text-align: center">{{ $material->description }}</td>
                                                <td style="text-align: center">{{ $material->stock}}</td>
                                                <td style="text-align: center">{{ $material->stock_transit }}</td>
                                                <td><button type="submit" wire:click.prevent="addmaterialsinorden({{$material->id}})" class="btn btn-primary btn-sm" >Agregar</button></td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="100%" class="py-3 italic">No hay ordenes agregadas.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
       
</div>

