<div class="card">
    <div class="card-header">
        <h3 class="card-title">Historial de precios del Proveedor</h3>
    </div>
    <!-- /.card-header -->

    <div class="card-body table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Material </th>
                    <th>Nombre</th>
                    <th>Precio en U$D</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prices as $price)
                    <tr>
                        <td>{{ $price->date }}</td>
                        <td>{{ $price->provider_price->material->code }}</td>
                        <td>{{ $price->provider_price->material->name }}</td>
                        <td>{{ $price->price }}</td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4" class="py-3 italic">No hay información</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->