<div>
  <div>
  <button wire:click="explorar({{ $cliente->id }})" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
  </div>
  <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th >Codigo de installation</th>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                      <th>P/U</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse($historial as $historia)
                <tr class="registros">
                      <td>{{ $historia->installation_id }}</td>
                      <td>{{ $historia->installations->description }}</td>
                      <td>{{ $historia->cantidad}}</td>
                      <td>{{ $historia->unit_price_usd}}</td>
                      <td>{{ $historia->unit_price_usd*$historia->cantidad }}</td>
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