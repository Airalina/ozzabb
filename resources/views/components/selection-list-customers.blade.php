@if ($showSelection)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Seleccione cliente a ser agregado:</h3>
            <br>
            <div class="input-group input-group-sm" style="width: 150px;">
                <input wire:model="customersData.searchCustomers" type="text"
                    class="form-control form-control-xs float-right" placeholder="Buscar cliente...">
            </div>
        </div>
        <!-- /.card-header -->
        @if ($searchCustomers != '')
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th style="text-align: center">Nombre</th>
                            <th style="text-align: center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td style="text-align: center">{{ $customer['name'] }}</td>
                                <td style="text-align: center"><button type="button"
                                        wire:click="selectCustomer({{ $customer['id'] }})"
                                        class="btn btn-success btn-sm">Seleccionar</button></td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="100%" class="py-3 italic">No hay información</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
        <!-- /.card-body -->
    </div>
@endif
<!-- /.card -->
@if (!empty($customerSelected))
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cliente seleccionado:</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align: center">Nombre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center">{{ $customerSelected['name'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endif
