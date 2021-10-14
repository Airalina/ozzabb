<div>
        <button wire:click="toexplora()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
</div>
<br>
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Retiros</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th style="text-align: center">Orden N°</th>
                      <th style="text-align: center">Código Material</th>
                      <th style="text-align: center">Descripción Material</th>
                      <th style="text-aling: center">Cantidad Retirada</th>
                      <th style="text-align: center">Destino</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($ordenegresodatail as $oregreso)
                    <tr>
                      <td style="text-align: center">{{ $oregreso->id }}</td>
                      <td style="text-align: center">{{ $oregreso->materials->code }}</td>
                      <td style="text-align: center">{{ $oregreso->materials->description }}</td>
                      <td style="text-align: center">{{ $oregreso->amount }}</td>
                      <td style="text-align: center">{{ $oregreso->destination }}</td>
                    </tr>
                    @empty
                      <tr class="text-center">
                        <td style="text-align: center" colspan="4" class="py-3 italic">No hay información</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
</div>