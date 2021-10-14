<div class="card-tools">
    <div>
        <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    </div>
    <br>
    <div class="card-header">
        <h6 class="card-title">Deposito: {{ $name }} </h6><br>
        <h6 class="card-title">Ubicación: {{ $location }} </h6><br>
        @if($type==1)
            <h6 class="card-title">Tipo: Almacen </h6><br>
        @elseif($type==2)
            <h6 class="card-title">Tipo: Producción </h6><br>
        @elseif($type==3)
            <h6 class="card-title">Tipo: Ensamblados </h6><br>
        @elseif($type==4)
            <h6 class="card-title">Tipo: Expedición </h6><br>
        @endif
        <h6 class="card-title">Descripción: {{ $descriptionw}} </h6><br>
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
                    @if($type==1||$type==2)
                    <div class="card-body table-responsive p-0">
                    <div>  
                      <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" wire:model="paginasinternas" class="form-control">
                    </div>
                                <table class="table table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">Id</th>
                                                    <th style="text-align: center">Codigo</th>
                                                    <th style="text-align: center">Descripción</th>
                                                    <th style="text-align: center">Presentación</th>
                                                    <th style="text-align: center">Cantidad</th>
                                                    <th style="text-align: center">Total<th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($materialesdepo as $material)
                                                    <tr>
                                                        <td style="text-align: center">{{ $material->material_id }}</td>
                                                        <td style="text-align: center">{{ $material->materials->code }}</td>
                                                        <td style="text-align: center">{{ $material->materials->description }}</td>
                                                        <td style="text-align: center">{{ $material->presentation }}</td>
                                                        <td style="text-align: center">{{ $material->amount }}</td>
                                                        <td style="text-align: center">{{ $material->presentation * $material->amount }}</td>
                                                    </tr>
                                                @empty
                                                    <tr class="text-center">
                                                        <td colspan="4" class="py-3 italic">No hay información</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                            </table>
                            {{ $materialesdepo->links() }}
                        </div>
                    @elseif($type==3)
                    <div class="card-body table-responsive p-0">
                        <div>  
                            <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" wire:model="paginasinternas" class="form-control">
                        </div>
                        <table class="table table-hover table-sm">
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
                            {{ $ensambladosdepo->links() }}
                        </div>
                    @elseif($type==4)
                    <div class="card-body table-responsive p-0">
                        <div>  
                            <label class="float-left">Registros por pagina:</label><input style="width: 60px; height: 30px" type="number" wire:model="paginasinternas" class="form-control">
                        </div>
                        <table class="table table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">N° de version</th>
                                                        <th style="text-align: center">N° de serie</th>
                                                        <th style="text-align: center">Codigo</th>
                                                        <th style="text-align: center">Descripción</th>
                                                        <th style="text-align: center">N° de pedido</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($instalacionesdepo as $instalaciones)
                                                        <tr>
                                                            <td style="text-align: center">{{ $instalaciones->revisions->number_version }}</td>
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
                                {{ $instalacionesdepo->links() }}
                            </div>
                  @endif
              </div>
</div>