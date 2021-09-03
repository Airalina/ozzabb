<div class="card-tools">
    <div>
        <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    </div>
    <br>
    <div class="card-header">
        <h6 class="card-title">Deposito: {{ $name }} </h6><br>
        <h6 class="card-title">Ubicación: {{ $location }} </h6><br>
        <h6 class="card-title">Propósito: {{ $purpose}} </h6><br>
        <h6 class="card-title">Fecha de creación: {{ date('d-m-Y', strtotime($create_date)) }} </h6><br>
        @if (auth()->user()->can('updatedepo', auth()->user()))
        <button style="margin-right: 5px" wire:click="retiros()" type="button" class="btn btn-primary"><i class="fas fa-file-alt"></i> Ver retiros de este depósito</button>
        
        <div class="card-tools">
                <button style="margin-right: 5px" wire:click="ingreso()" type="button" class="btn btn-info">Nuevo Ingreso</button>
        
                <button wire:click="egreso()" type="button" class="btn btn-info">Nuevo Egreso</button>
        </div>
        @endif
        <br>
        <br>
        <br>
        <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Materiales</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Ensamblados</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Instalaciones</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Ordenes de Ingreso</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">Id</th>
                                                    <th style="text-align: center">Codigo</th>
                                                    <th style="text-align: center">Descripción</th>
                                                    <th style="text-align: center">Cantidad</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($materialesdepo as $material)
                                                    <tr>
                                                        <td style="text-align: center">{{ $material->material_id }}</td>
                                                        <td style="text-align: center">{{ $material->materials->code }}</td>
                                                        <td style="text-align: center">{{ $material->materials->description }}</td>
                                                        <td style="text-align: center">{{ $material->amount }}</td>
                                                    </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="4" class="py-3 italic">No hay información</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                            <thead>
                                                <tr>
                                                    <th style="text-align: center">Id ensamblado</th>
                                                    <th style="text-align: center">Descripción</th>
                                                    <th style="text-align: center">Cantidad</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($ensambladosdepo as $ensamblado)
                                                    <tr>
                                                        <td style="text-align: center">{{ $ensamblado->material_id }}</td>
                                                        <td style="text-align: center">{{ $ensamblado->assembleds->description }}</td>
                                                        <td style="text-align: center">{{ $ensamblado->amount }}</td>
                                                    </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="4" class="py-3 italic">No hay información</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                        <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">Id</th>
                                                        <th style="text-align: center">N° de serie</th>
                                                        <th style="text-align: center">Codigo</th>
                                                        <th style="text-align: center">Descripción</th>
                                                        <th style="text-align: center">N° orden</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($instalacionesdepo as $instalaciones)
                                                        <tr>
                                                            <td style="text-align: center">{{ $instalaciones->installation_id }}</td>
                                                            <td style="text-align: center">{{ $instalaciones->serial_number }}</td>
                                                            <td style="text-align: center">{{ $instalaciones->revisions->installations->code }}</td>
                                                            <td style="text-align: center">{{ $instalaciones->revisions->installations->description }}</td>
                                                            <td style="text-align: center">{{ $instalaciones->client_order_id }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr class="text-center">
                                                            <td colspan="4" class="py-3 italic">No hay información</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                        <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">N° orden de entrada</th>
                                                        <th style="text-align: center">N° orden de compra</th>
                                                        <th style="text-align: center">N° de remito</th>
                                                        <th style="text-align: center">Fecha</th>
                                                        <th style="text-align: center">Hora</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($ordenesdepo as $orden)
                                                        <tr>
                                                            <td style="text-align: center">{{ $orden->entry_order_id }}</td>
                                                            <td style="text-align: center">{{ $orden->buy_order_id }}</td>
                                                            <td style="text-align: center">{{ $orden->follow_number }}</td>
                                                            <td style="text-align: center">{{ date('d-m-Y', strtotime($orden->date)) }}</td>
                                                            <td style="text-align: center">{{ $orden->hour }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr class="text-center">
                                                            <td colspan="4" class="py-3 italic">No hay información</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                </table>
                            </div>
                    </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
    </div>
</div>