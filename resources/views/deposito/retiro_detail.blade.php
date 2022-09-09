<div>
    <button wire:click="backToRetiros()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Detalle de retiro N°: {{ $withdraw['details']['retiro']['id'] }}</h3>

    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <x-list-withdraws-details :withdraws="$withdraw['details']" detail='0' />
        <div class="mt-4">
            <div class="card-header">
                <h3 class="card-title">Detalle de ingresos al depósito:
                    {{ $withdraw['details']['retiro']['warehouse_name'] }}
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="table-responsive">
                <x-list-withdraws-details :withdraws="$withdraw['entry']" detail='0' type='1'/>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.card-body -->
</div>
