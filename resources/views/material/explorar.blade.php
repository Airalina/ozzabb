<div class="card-body table-responsive p-0">
    
    <table class="table table-hover text-nowrap">
                  <thead>
                    
                    <div class="card-tools">
                    <div>
                      <button wire:click="back()" type="button" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Volver</button>
    	            </div>
                    <br>
                    <h6>    Usted a seleccionado el material con codigo: {{ $material->id }} </h6>
                </div>
                    <tr>
                    <th>ID</th>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Familia</th>
                      <th>Color</th>
                      <th>Linea</th>
                      <th>Uso</th>
                      <th>Remplazo</th>
                      <th>Stock Min.</th>
                      <th>Stock Max.</th>
                      <th>Stock</th>
                      <th><th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ $material->id }} </td>
                      <td>{{ $material->code }} </td>
                      <td>{{ $material->name }} </td>
                      <td>{{ $material->family }} </td>
                      <td>{{ $material->color }} </td>
                      <td>  @if($material->line != null)
                              {{$material->line->name}} 
                            @endif
                      </td>
                      <td>@if($material->usage != null)
                              {{$material->usage->name}} 
                            @endif
                      </td>
                      <td> @if($material->material != null)
                              {{ $material->material->name }}
                            @endif
                      </td>
                      <td>{{ $material->stock_min }} </td>
                      <td>{{ $material->stock_max }} </td>
                      <td>{{ $material->stock }} </td>
                      <td>
                        @if (auth()->user()->can('updateprovider', auth()->user()))
                          <button wire:click="update({{ $material->id }})" type="button"  class="btn btn-primary btn-sm">Actualizar</button>
                        @endif
                        @if (auth()->user()->can('deleteprovider', auth()->user())) 
                          <button wire:click="destruir({{ $material->id }})" type="button" class="btn btn-danger btn-sm">Borrar</button>
                        @endif
                      <td>
                    </tr>
                  </tbody>
    </table>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de precios del material</h3>
                <div class="card-tools">
                  @if (auth()->user()->can('storeprovider', auth()->user()))  
                    <div>
                      <button wire:click="agregamat({{ $material->id }})" type="button" class="btn btn-info">Agregar Material</button>
    	              </div>
                  @endif
                </div>
            </div>
             
            <!-- /.card -->
          </div>
</div>