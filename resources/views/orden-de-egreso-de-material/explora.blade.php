<div>
    <button wire:click="volver()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Detalle de orden de egreso: {{ $material_release_order_id }}</h3>
    </div>
    <form>
        <div class="card-body">
            <h5>Datos de orden de egreso de materiales</h5>
            <br>
            <div class="card-body">
                <br>
                <div class="form-group">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Productos agregados:</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Producto</th>
                                            <th style="text-align: center">Código</th>
                                            <th style="text-align: center">Descripción</th>
                                            <th style="text-align: center">Packaging</th>
                                            <th style="text-align: center">Cantidad</th>
                                            <th style="text-align: center">Deposito</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($details as $type => $product_type)
                                        @foreach ($product_type as $prod)
                                        <tr>
                                            <td style="text-align: center">{{ $prod['type'] }}</td>
                                            <td style="text-align: center">{{ $prod['code'] }}</td>
                                            <td style="text-align: center">{{ $prod['description'] }}</td>
                                            <td style="text-align: center">{{ $prod['presentation'] }}</td>
                                            <td style="text-align: center">{{ $prod['amount'] }}</td>
                                            <td style="text-align: center">{{ $prod['warehouse_name'] }}</td>
                                            
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        <div class="form-group">
                            <label>Destino</label>
                            <input class="form-control form-control-sm" type="text" wire:model="destination"
                                style="width: 300px;" placeholder="Ingrese el destino" readonly>
                        </div>
                        <div class="form-group">
                            <label>Responsable del retiro</label>
                            <input class="form-control form-control-sm" type="text" wire:model="responsible"
                                style="width: 300px;" placeholder="Ingrese el responsable del retiro" readonly>
                        </div>
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" wire:model="date" class="form-control form-control-sm"
                                style="width: auto" placeholder="dd/mm/AAAA" readonly>
                        </div>
                        <div class="form-group">
                            <label>Hora</label>
                            <input type="time" wire:model="hour" class="form-control form-control-sm"
                                style="width: auto" placeholder="" readonly>
                        </div>
                    </div>

    </form>

</div>