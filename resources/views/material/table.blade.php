<div class="card">
              <div class="card-header">
                <h3 class="card-title">Materiales</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="search" wire:model="search" class="form-control float-right" placeholder="Buscar">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
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
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($materials as $material)
                    <tr>
                      <td>{{ $material->id }}
                      <td>{{ $material->code }}
                      <td>{{ $material->name }}
                      <td>{{ $material->family }}
                      <td>{{ $material->color }}
                      <td>{{ $material->line_id }}
                      <td>{{ $material->usage_id }}
                      <td>{{ $material->replace }}
                      <td>{{ $material->stock_min }}
                      <td>{{ $material->stock_max }}
                      <td>{{ $material->stock }}
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="11">
                        {{ $materials->links() }}
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
