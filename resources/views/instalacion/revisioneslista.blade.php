<div>
    <button wire:click="backToExplorar()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
        Volver</button>
</div>
<br>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Detalle de revisión </h3>
        </div>
        <div class="card-body">
            <x-form-revisions disabled='disabled' />
            <br>
            <div class="form-group table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center">Código Material</th>
                            <th style="text-align: center">Descripción</th>
                            <th style="text-align: center">Cantidad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($revisionDetails['materials'] as $material)
                            <tr>
                                <td style="text-align: center">{{ $material['code'] }}</td>
                                <td style="text-align: center">{{ $material['description'] }}</td>
                                <td style="text-align: center">{{ $material['amount'] }}</td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4" class="py-3 italic">No hay información</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($files['images'][0])
                <x-img-create-card :files="$files" :funcion="'explorar'" />
            @endif
        </div>
    </div>
</div>
