<div>
    <button wire:click="backexpl()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div><br>
<div>
    <div class="card card-tabs">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <div class="card-body table-responsive">
            <form>
                <div class="card-header">
                    <h3 class="card-title">Pedidos de clientes en orden de trabajo:</h3>
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
                            @forelse($clientworkorders as $clientworkorder)
                            <tr>
                                <td style="text-align: center">{{ $clientworkorder->clientorder_id }}/{{ date('Y', strtotime($clientworkorder->clientorder->date))}}
                                </td>
                                <td style="text-align: center">{{ $clientworkorder->clientorder->customer_name }}</td>
                                <td style="text-align: center">{{ date('d/m/Y', strtotime($clientworkorder->clientorder->date))}}</td>
                                @switch($clientworkorder->clientorder->order_state)
                                @case(1)
                                <td style="text-align: center">Nuevo</td>
                                @break
                                @case(2)
                                <td style="text-align: center">Confirmado</td>
                                @break
                                @case(3)
                                <td style="text-align: center">Rechazado</td>
                                @break
                                @case(4)
                                <td style="text-align: center">Demorado</td>
                                @break
                                @case(5)
                                <td style="text-align: center">En producción</td>
                                @break
                                @case(6)
                                <td style="text-align: center">En depósito</td>
                                @break
                                @case(7)
                                <td style="text-align: center">Cancelado</td>
                                @break
                                @endswitch
                                <td style="text-align: center">{{ date('d/m/Y', strtotime($clientworkorder->clientorder->date))}}</td>
                                @switch($clientworkorder->clientorder->buys)
                                @case(null):
                                <td style="text-align: center">No</td>
                                @break
                                @case(1)
                                <td style="text-align: center">No</td>
                                @break
                                @case(2)
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
                            <button type="button" wire:click.prevent="buscamaterial()" class="btn btn-success btn-sm"
                                style="float: right">Agregar material a la orden</button>
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
                                <th style="text-align: center">Packaging</th>
                                <th style="text-align: center">Cantidad</th>
                                <th style="text-align: center">Cantidad total</th>
                                <th style="text-align: center">P/U U$D</th>
                                <th style="text-align: center">Subtotal U$D</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientorders as $clientorder)
                                    <tr>
                                        <td style="text-align: center">{{ $clientorder[1] }}</td>
                                        <td style="text-align: center">{{ $clientorder[2] }}</td>
                                        <td style="text-align: center">{{ $clientorder[3] }}</td>
                                        <td style="text-align: center">{{ $clientorder[4] }}</td>
                                        <td style="text-align: center">{{ $clientorder[5] }}</td> 
                                        <td style="text-align: center">{{ $clientorder [10] }}</td>
                                        <td style="text-align: center">{{ $clientorder [6] }}</td>
                                        <td style="text-align: center">{{ $clientorder [7] }}</td>
                                        <td style="text-align: center">{{ $clientorder [8] }}</td>
                                        <td style="text-align: center">{{ $clientorder [9] }}</td>
                                        <td style="text-align: center">{{ $clientorder [11] }}</td>
                                        <td style="text-align: center"><button type="button" wire:click="buy({{$clientorder[12]}})"class="btn btn-success btn-sm">Comprar</button></td>
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
                    <button wire:click="save_pucharsing()" type="button" class="btn btn-primary">Realizar pedido</button>
                </div>
            </form>
        </div>
        <div wire:ignore.self class="modal" id="form-material" tabindex="-1" role="dialog">
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
                        <x-form-validation-errors :errors="$errors" />
                          <div class="form-group">
                            <p><label>Codigo: </label>{{$material_code}}</p>
                          </div>
                          <div class="form-group">
                            <p><label>Descripción: </label>{{$material_description}}</p>
                          </div>
                          <div class="form-group">
                              <label>Seleccione un proveedor, para ver las presentaciones disponibles.</label>
                              <select class="form-control form-control-sm select2 select2-hidden-accessible" wire:model="proveedor_selected" style="width: auto" wire:change="change_presentation()">
                                  <option selected="selected" hidden="">Seleccione un proveedor</option>
                                  @foreach($providers as $provider)
                                      <option value="{{ $provider->provider_id }}">{{ $provider->provider->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                          @if(!empty($proveedor_selected))
                          <div class="form-group">
                              <label>Packaging:</label>
                              <select class="form-control form-control-sm select2 select2-hidden-accessible" wire:model="presentationm" wire:change="change_price()" style="width: auto">
                                  <option selected="selected" hidden="">Seleccione un packaging</option>
                                  @foreach($provider_presentations as $presentation)
                                      <option value="{{ $presentation }}">{{ $presentation->unit }}  {{ $presentation->presentation }}</option>
                                  @endforeach
                              </select>
                          </div>
                          @endif
                          @if($presentationm!=null)
                          <div class="form-group">
                              <label>Precio U$D:{{$usd_price}}</label>
                              <br>
                              <label>Precio AR$:{{$ars_price}}</label>
                          </div>
                          @endif
                          <div class="form-group">
                              <label>Cantidad:</label>
                              <input wire:model.defer="amount" type="number">
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" wire:click.prevent="buy_confirm()" class="btn btn-primary btn-sm" >Agregar</button>
                        <button type="button" class="btn btn-danger btn-sm" wire:click.prevent="backmodal()" data-dismiss="modal">Cancelar</button>
                      </div>
                    </div>
                  </form>
            </div>
        </div>
        <div wire:ignore.self class="modal" id="form-addmaterial" tabindex="-1" role="dialog">
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" wire:click.prevent="backmodal()" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>